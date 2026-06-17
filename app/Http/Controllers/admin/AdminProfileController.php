<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
        if ($user && in_array(strtolower($user->role ?? ''), ['admin', 'vendor'])) {
            return $user;
        }

        // Fallback: session id was from tbl_info_login (old broken login route)
        // Use the mobile stored in session to look up the real admin row
        $mobile = session('user_mobile');
        if ($mobile) {
            $user = User::where('mobile_no', $mobile)->first();
            if ($user && in_array(strtolower($user->role ?? ''), ['admin', 'vendor'])) {
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
            'mobile_no'  => 'required',
            'email'      => 'nullable|email',

            'profile_photo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('profile_photo')) {
            if (
                $user->profile_photo &&
                Storage::disk('public')->exists(
                    $user->profile_photo
                )
            ) {

                Storage::disk('public')->delete(
                    $user->profile_photo
                );
            }

            $file = $request->file('profile_photo');

            $filename =
                time() .
                '_' .
                $file->getClientOriginalName();

            $file->storeAs(
                'profile-photos',
                $filename,
                'public'
            );

            $profilePhoto =
                'profile-photos/' .
                $filename;
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
}
