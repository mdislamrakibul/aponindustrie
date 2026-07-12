<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login;
use App\Models\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Resolve the User (tbl_info_user) for the current admin session,
     * mirroring the same dual-path strategy used in CustomerProfileController:
     *
     *   New flow (adminLogin):  session('user_id') = tbl_info_user.id  → User::find()
     *   Old flow (customer /login redirected to admin): session('user_id') = tbl_info_login.id
     *     → fall back to mobile_no stored in session to find the real admin record
     */
    private function resolveUser(): ?User
    {
        $sid = session('user_id');
        if (!$sid) {
            return null;
        }

        // Primary path: session id matches tbl_info_user.id directly
        $user = User::find($sid);
        if ($user && in_array(strtolower($user->role ?? ''), ['admin', 'vendor', 'cashier'])) {
            return $user;
        }

        // Fallback: session id was from tbl_info_login (old broken login route)
        // Use the mobile stored in session to look up the real admin row
        $mobile = session('user_mobile');
        if ($mobile) {
            $user = User::where('mobile_no', $mobile)->first();
            if ($user && in_array(strtolower($user->role ?? ''), ['admin', 'vendor', 'cashier'])) {
                return $user;
            }
        }

        return null;
    }

    public function index()
    {
        $user = $this->resolveUser();

        if (!$user) {
            return redirect('/admin/management-login')
                ->with('error', 'Please log in to access your profile.');
        }

        return view(
            'admin.profile.index',
            compact('user')
        );
    }

    public function update(Request $request)
    {
        $user = $this->resolveUser();

        if (!$user) {
            return redirect('/admin/management-login')
                ->with('error', 'Session expired. Please log in again.');
        }

        $profilePhoto = $user->profile_photo;

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'mobile_no'  => ['required', 'regex:/^(01)[3-9]\d{8}$/'],
            'email'      => 'nullable|email',

            'profile_photo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'mobile_no.regex' => 'Enter a valid 11-digit mobile number, ',
        ]);
        if ($request->hasFile('profile_photo')) {
            $dir = upload_root('uploads/profile-photos');
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0775, true);
            }

            if ($user->profile_photo && File::exists(upload_root($user->profile_photo))) {
                File::delete(upload_root($user->profile_photo));
            }

            $file     = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($dir, $filename);

            $profilePhoto = 'uploads/profile-photos/' . $filename;
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'mobile_no'  => $request->mobile_no,
            'email'      => $request->email,
            'profile_photo' => $profilePhoto,

        ]);

        session([
            'user_mobile' => $user->mobile_no,
            'user_name' => $user->first_name . ' ' . $user->last_name
        ]);

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }

    public function updatePassword(Request $request)
    {
        $user = $this->resolveUser();

        if (!$user) {
            return redirect('/admin/management-login')
                ->with('error', 'Session expired. Please log in again.');
        }

        $request->validateWithBag('password', [
            'current_password' => 'required',
            'new_password'      => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'], 'password');
        }

        $user->update([
            'password' => $request->new_password,
        ]);

        // The storefront /login route authenticates against tbl_info_login
        // (Login model), a separate table from tbl_info_user — keep both in
        // sync so the new password works from either login entry point.
        $login = $user->login_id
            ? Login::find($user->login_id)
            : Login::where('phone', $user->mobile_no)->first();

        if ($login) {
            $login->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        // Alert admin whenever a non-admin admin-panel account (cashier,
        // vendor) changes its own password, since these are shared/managed
        // accounts an admin should be aware of.
        if (strtolower($user->role) !== 'admin') {
            $name = trim($user->first_name . ' ' . $user->last_name);

            Notification::create([
                'title'                 => ucfirst($user->role) . ' changed their password',
                'message'               => $name . ' (' . $user->mobile_no . ') changed their account password.',
                'target_role'           => 'admin',
                'triggered_by_user_id'  => $user->id,
                'triggered_by_name'     => $name,
            ]);
        }

        return back()->with('password_success', 'Password Changed Successfully');
    }
}
