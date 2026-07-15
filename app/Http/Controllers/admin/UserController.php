<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Login;
use App\Models\ActivityLog;
use App\Services\UserSyncService;

class UserController extends Controller
{

    public function index()
    {
        // User Management shows staff accounts only (vendor/cashier/admin).
        // Customer accounts are managed exclusively under Customer Management.
        $users = User::where('role', '!=', 'customer')->get();

        $totalUsers = User::where('role', '!=', 'customer')->count();

        $activeUsers = User::where('role', '!=', 'customer')->where('status', 'active')->count();

        $inactiveUsers = User::where('role', '!=', 'customer')->where('status', 'inactive')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers'
        ));
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
                    'unique:tbl_info_user,mobile_no',
                    'unique:tbl_info_login,phone',
                ],

                'email' => 'nullable|email|max:255|unique:tbl_info_login,email',

                'role' => 'required|in:admin,vendor,cashier',

                'password' => 'required|min:6',

            ]);

            // Create in tbl_info_login first (the table the shared /login page
            // authenticates against), then sync into tbl_info_user (used by
            // the /admin/management-login route and admin session data) —
            // the same pattern used by customer self-registration, so a user
            // created here can log in from either entry point.
            $loginUser = Login::create([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'name'       => trim($validated['first_name'] . ' ' . $validated['last_name']),
                'phone'      => $validated['mobile_no'],
                'email'      => $validated['email'] ?? null,
                'password'   => Hash::make($validated['password']),
                'role'       => $validated['role'],
                'status'     => 'active',
            ]);

            UserSyncService::syncToUserTable($loginUser);

            ActivityLog::create([
                'user_id'      => session('user_id'),
                'performed_by' => session('user_name'),
                'module'       => 'User Management',
                'item'         => $validated['first_name'],
                'action'       => 'CREATE',
                'details'      => 'Created user: ' . $validated['first_name'] . ' (' . $validated['role'] . ')',
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

            'role' => 'required|in:admin,vendor,customer,cashier',

            'status' => 'required|in:active,inactive',

        ]);
        $oldUser = DB::table('tbl_info_user')
            ->where('id', $id)
            ->first();
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

        $newUser = DB::table('tbl_info_user')
            ->where('id', $id)
            ->first();

        $changes = [];

        if ($oldUser->first_name != $newUser->first_name) {

            $changes[] =
                'First Name: '
                . $oldUser->first_name
                . ' → '
                . $newUser->first_name;
        }

        if ($oldUser->role != $newUser->role) {

            $changes[] =
                'Role: '
                . $oldUser->role
                . ' → '
                . $newUser->role;
        }

        if ($oldUser->status != $newUser->status) {

            $changes[] =
                'Status: '
                . $oldUser->status
                . ' → '
                . $newUser->status;
        }
        if (count($changes) > 0) {

            ActivityLog::create([
                'user_id'      => session('user_id'),
                'performed_by' => session('user_name'),
                'module'       => 'User Management',
                'item'         => $newUser->first_name,
                'action'       => 'UPDATE',
                'details'      => 'Updated user: ' . $newUser->first_name . ' | Changes: ' . implode(', ', $changes),
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Status update user
     */

    public function toggleStatus($id)
    {
        $user = DB::table('tbl_info_user')
            ->where('id', $id)
            ->first();

        if (!$user) {

            return response()->json([
                'success' => false
            ]);
        }

        $newStatus =
            $user->status == 'active'
            ? 'inactive'
            : 'active';

        DB::table('tbl_info_user')
            ->where('id', $id)
            ->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);

        ActivityLog::create([
            'user_id'      => session('user_id'),
            'performed_by' => session('user_name'),
            'module'       => 'User Management',
            'item'         => $user->first_name,
            'action'       => 'STATUS CHANGE',
            'details'      => 'User status changed from ' . $user->status . ' to ' . $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status' => $newStatus
        ]);
    }
}
