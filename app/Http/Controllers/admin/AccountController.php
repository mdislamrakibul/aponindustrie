<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    // LIST (user-wise)
    public function index()
    {
        $accounts = DB::table('tbl_user_accounts')
            ->join('tbl_info_user', 'tbl_user_accounts.user_id', '=', 'tbl_info_user.id')
            ->select('tbl_user_accounts.*', 'tbl_info_user.first_name')
            ->get();

        return view('admin.accounts.index', compact('accounts'));
    }

    // CREATE PAGE
    public function create($id)
    {
        $user = DB::table('tbl_info_user')->where('id', $id)->first();

        return view('admin.accounts.create', compact('user'));
    }

    // STORE
    public function store(Request $request, $id)
    {
        DB::table('tbl_user_accounts')->insert([
            'user_id' => $id,
            'amount' => $request->amount,
            'type' => $request->type,
            'note' => $request->note,
            'created_at' => now()
        ]);

        return redirect()->route('admin.accounts.index', $id)
            ->with('success', 'Salary Added Successfully');
    }

    // EDIT
    public function edit($id)
    {
        $account = DB::table('tbl_user_accounts')->where('id', $id)->first();

        return view('admin.accounts.edit', compact('account'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        DB::table('tbl_user_accounts')
            ->where('id', $id)
            ->update([
                'amount' => $request->amount,
                'type' => $request->type,
                'note' => $request->note,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Updated Successfully');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('tbl_user_accounts')->where('id', $id)->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}