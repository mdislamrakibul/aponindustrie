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
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'mobile_no'   => 'required|unique:tbl_info_user',
            'role' => 'required|in:admin,vendor,customer'
        ]);

        DB::table('tbl_info_user')->insert([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'mobile_no'  => $request->mobile_no,
            'role'       => $request->role,
            'status'     => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users')
                         ->with('success', 'User created successfully');
    }

    /**
     * Edit user
     */
    public function edit($id)
    {
        $user = DB::table('tbl_info_user')
                    ->where('id', $id)
                    ->first();

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        DB::table('tbl_info_user')
            ->where('id', $id)
            ->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'mobile_no'  => $request->mobile_no,
                'role'       => $request->role,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.users')
                         ->with('success', 'User updated successfully');
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