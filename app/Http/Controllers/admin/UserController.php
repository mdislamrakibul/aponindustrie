<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Show all users
     */
    public function index()
    {
        $users = DB::table('tbl_info_user')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([

                'first_name' => 'required|string|max:255',

                'last_name' => 'nullable|string|max:255',

                'mobile_no' => [
                    'required',
                    'regex:/^(01)[3-9]\d{8}$/',
                    'unique:tbl_info_user,mobile_no'
                ],

                'role' => 'required|in:admin,vendor,customer',

            ]);

            DB::table('tbl_info_user')->insert([

                'first_name' => $validated['first_name'],

                'last_name' => $validated['last_name'],

                'mobile_no' => $validated['mobile_no'],

                'role' => $validated['role'],

                'status' => 'active',

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            return redirect()
                ->route('admin.users')
                ->with('success', 'User created successfully');

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',

            'mobile_no' => [
                'required',
                'regex:/^(01)[3-9]\d{8}$/',
                'unique:tbl_info_user,mobile_no,' . $id
            ],

            'role' => 'required|in:admin,vendor,customer',

            'status' => 'required|in:active,inactive',

        ]);

        DB::table('tbl_info_user')
            ->where('id', $id)
            ->update([

                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_no'  => $request->mobile_no,
                'role'       => $request->role,
                'status'     => $request->status,
                'updated_at' => now(),

            ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        DB::table('tbl_info_user')
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.users')
                         ->with('success', 'User deleted successfully');
    }
}