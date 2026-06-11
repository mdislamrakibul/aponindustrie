<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = User::where(
            'login_id',
            session('user_id')
        )->firstOrFail();

        return view(
            'admin.profile.index',
            compact('user')
        );
    }

    public function update(Request $request)
    {
        $user = User::where(
            'login_id',
            session('user_id')
        )->firstOrFail();

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
