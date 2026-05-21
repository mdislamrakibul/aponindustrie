<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AccountController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | SALARY PAGE
    |--------------------------------------------------------------------------
    */

    public function salary()
    {
        $users = DB::table('tbl_info_user')
            ->whereIn('role', ['admin', 'vendor'])
            ->orderBy('created_at', 'desc')
            ->get();

        $accounts = DB::table('tbl_user_accounts')
            ->join(
                'tbl_info_user',
                'tbl_user_accounts.user_id',
                '=',
                'tbl_info_user.id'
            )
            ->select(
                'tbl_user_accounts.*',
                'tbl_info_user.first_name',
                'tbl_info_user.last_name',
                'tbl_info_user.role',
                'tbl_info_user.salary'
            )
            ->latest('tbl_user_accounts.id')
            ->get();

        return view('admin.salary.index', compact(
            'users',
            'accounts'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE SALARY
    |--------------------------------------------------------------------------
    */

    public function salaryStore(Request $request)
    {
        $request->validate([

            'user_id' => 'required',

            'amount' => 'required|numeric',

            'type' => 'required',

            'note' => 'nullable',
        ]);

        DB::table('tbl_user_accounts')->insert([

            'user_id' => $request->user_id,

            'amount' => $request->amount,

            'type' => $request->type,

            'note' => $request->note,

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER SALARY COLUMN
        |--------------------------------------------------------------------------
        */

        DB::table('tbl_info_user')
            ->where('id', $request->user_id)
            ->update([
                'salary' => $request->amount,
                'updated_at' => now(),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Salary added successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SALARY
    |--------------------------------------------------------------------------
    */

    public function salaryUpdate(Request $request, $id)
    {
        $request->validate([

            'amount' => 'required|numeric',

            'type' => 'required',

            'note' => 'nullable',
        ]);

        DB::table('tbl_user_accounts')
            ->where('id', $id)
            ->update([

                'amount' => $request->amount,

                'type' => $request->type,

                'note' => $request->note,

                'updated_at' => now(),
            ]);

        return redirect()
            ->back()
            ->with('success', 'Salary updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE SALARY
    |--------------------------------------------------------------------------
    */

    public function salaryDelete($id)
    {
        DB::table('tbl_user_accounts')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Salary deleted successfully');
    }
}