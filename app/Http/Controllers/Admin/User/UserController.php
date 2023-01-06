<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = User::orderBy("id","DESC")->paginate(5);
        return view("backend/user/listuser",["user"=>$user]);
    }
    public function create()
    {
        return view("backend/user/adduser");
    }
    public function insert(AddUserRequest $addUserRequest){
        $user = new User();
        $user->fullname = $addUserRequest->fullname;
        $user->email = $addUserRequest->email;
        $user->password = Hash::make($addUserRequest->password);
        $user->phone = $addUserRequest->phone;
        $user->address = $addUserRequest->address;
        $user->level = $addUserRequest->level;
        $user->save();
        return redirect("/admin/user");
    }
    public function edit($id){
        $user = User::find($id)->toArray();
        // dd($user);
        return view("backend/user/edituser",["user"=>$user]);
    }
    public function update(EditUserRequest $editUserRequest,$id){
        $user = User::find($id);
        $user->fullname = $editUserRequest->fullname;
        $user->email = $editUserRequest->email;
        $user->password = Hash::make($editUserRequest->password);
        $user->phone = $editUserRequest->phone;
        $user->address = $editUserRequest->address;
        $user->level = $editUserRequest->level;
        $user->save();
        $editUserRequest->session()->flash("alert", "Đã sửa thành công");

        return redirect("/admin/user");
    }
    public function delete(Request $request ,$id){
        $deluser = User::find($id);
        $request->session()->flash('delname', $deluser->email);
        $deluser->delete();

        $request->session()->flash("alert", "Đã xóa thành công user ");

        return redirect("/admin/user");
    }

}
