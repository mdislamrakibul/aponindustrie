<?php
class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('tbl_info_user')->get();
        return view('admin.users', compact('users'));
    }
}