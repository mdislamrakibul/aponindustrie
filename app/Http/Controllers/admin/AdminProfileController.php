<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = User::where(
            'mobile_no',
            session('user_mobile')
        )->firstOrFail();

        return view(
            'admin.profile.index',
            compact('user')
        );
    }

    public function update(Request $request)
    {
        $user = User::where(
            'mobile_no',
            session('user_mobile')
        )->firstOrFail();

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'mobile_no'  => 'required',
            'email'      => 'nullable|email',

            'profile_photo' =>

                'nullable|
                image|
                mimes:jpg,jpeg,png,webp|
                max:2048',
        ]);
        if ($request->hasFile('profile_photo')) {

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
            'user_name' =>
            trim(
                $request->first_name .
                ' ' .
                $request->last_name
            )
        ]);

        return back()->with(
            'success',
            'Profile Updated Successfully'
        );
    }
}