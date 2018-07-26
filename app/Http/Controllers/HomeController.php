<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = $request->user()->getRoles($user->id);
        $users = [];
        foreach (User::all() as $key => $value) {
          $arr['id'] = $value['id'];
          $arr['name'] = $value['name'];
          $arr['email'] = $value['email'];
          $arr['role'] = $request->user()->getRoles($value['id']);
          array_push($users, $arr);
        }
        return view('home',['title' => 'manager', 'roles' => $roles, 'users' => $users]);
    }

    public function datatable(Request $request)
    {
      $user = Auth::user();
      $roles = $request->user()->getRoles($user->id);
      $users = [];
      foreach (User::all() as $key => $value) {
        $arr['id'] = $value['id'];
        $arr['name'] = $value['name'];
        $arr['email'] = $value['email'];
        $arr['role'] = $request->user()->getRoles($value['id']);
        array_push($users, $arr);
      }
      return Datatables::of($users)->make(true);

    }

    public function video(Request $request)
    {

      $data = $request->all();
      $video = $data['video'];
      $input = $video->getClientOriginalName();
      $destinationPath = public_path().'\uploads';
      $video->move($destinationPath, $input);
      return redirect()->back()->with('upload_success','upload_success');

    }

    public function edit_form($id, Request $request)
    {
      $value = User::find($id);
      $arr['id'] = $value['id'];
      $arr['name'] = $value['name'];
      $arr['email'] = $value['email'];
      $arr['role'] = $request->user()->getRoles($value['id']);
      $role = DB::table('roles')->get();
      return view('form_edit',['title' => 'Edit profile '.$arr['name'] ,'user' => $arr, 'roles' => $role]);
    }

    public function edit_save(Request $request)
    {
      $parm = $request->all();
      DB::table('role_user')->where('user_id', $parm['id'])->delete();
      foreach ($parm['roles'] as $key => $value) {
        DB::table('role_user')->insert([
          'role_id' => $value,
          'user_id' => $parm['id']]
        );
      }
      User::where('id', $parm['id'])->update(['name' => $parm['name']]);
      return redirect('home');

    }
}
