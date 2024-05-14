<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\User;
use App\Models\Department;
use App\Models\UserRole;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class User_managementController extends Controller
{
    public function add_user()
    {
        $departments = Department::get()->all();
        $user_role = UserRole::get()->all();
        return view('admin.user_management.add_user',compact('departments','user_role'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'Whatsapp' => 'required',
            'Telegram' => 'required',
            'email' => 'required|email|unique:users',
            'department' => 'required',
            'batch_id' => 'required',
            'address' => 'required',
            'password' => 'required|min:8|confirmed', // Add "confirmed" rule for password
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'password.confirmed' => 'Password and Confirm Password do not match',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                Toastr::error($error, 'Error');
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $saveuser = new User();
        $saveuser->name = $request->input('name');
        $saveuser->role_id = $request->role_id;
        $saveuser->mobile = $request->input('mobile');
        $saveuser->Whatsapp = $request->input('Whatsapp');
        $saveuser->Telegram = $request->input('Telegram');
        $saveuser->email = $request->input('email');
        $saveuser->department = $request->input('department');
        $saveuser->batch_id = $request->input('batch_id');
        $saveuser->address = $request->input('address');

        // Check if password and password_confirmation match before hashing the password
        if ($request->input('password') === $request->input('password_confirmation')) {
            $saveuser->password = Hash::make($request->input('password'));
        } else {
            return back()->with('error', 'Password and Confirm Password do not match');
        }

        if ($request->hasFile('image')) {
            $saveuser->image = $this->saveImage($request);
        } else {
            $saveuser->image = 'adminAsset/user-image/default.jpg';
        }

        $saveuser->save();
        if($saveuser->save()){
            Toastr::success('User created Successfully' , 'success');
        }
        return back()->with('message', 'Info saved successfully');
    }

    private function saveImage($request)
    {
        $image = $request->file('image');
        $imageName = rand() . '.' . $image->getclientOriginalExtension();
        $directory = 'adminAsset/user-image/';
        $imgurl = $directory . $imageName;
        $image->move($directory, $imageName);
        return $imgurl;
    }

    public function all_user()
    {
        return view('admin.user_management.all_user', [
            'saveusers' => User::all()
        ]);
    }

    public function edit($id)
    {
        $saveuser = User::find($id);
        $departments = Department::get(); // Retrieve all departments
        return view('admin.user_management.edit', compact('saveuser', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'Whatsapp' => 'required',
            'Telegram' => 'required',
            'email' => 'required|email',
            'department' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If password and confirm password are provided, validate them.
        // if (!empty($request->password) || !empty($request->password_confirmation)) {
        //     $validator->addRules([
        //         'password' => 'required|min:8|confirmed',
        //     ]);
        // }
        $validator->sometimes('password', ['required', 'min:8', 'confirmed'], function ($input) {
            return !empty($input->password) || !empty($input->password_confirmation);
        });

        if ($validator->fails()) {

            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                Toastr::error($error, 'Error');
            }
            return back()->withErrors($validator)->withInput();
        }
        $department = Department::where('depart_id',$request->department)->get()->first();
        // dd( $request->all(),$request->department,$request->input('department'),$department->department);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->Whatsapp = $request->Whatsapp;
        $user->Telegram = $request->Telegram;
        $user->email = $request->email;
        $user->department = $department->department;
        $user->batch_id = $request->batch_id;
        $user->address = $request->address;

        // Update the password only if it's provided.
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $user->image = $this->saveImage($request);
        }

        $user->update();
        if($user->update()){
            Toastr::success('user updated successfully', 'success');
        }
        return redirect()->route('admin.user_management.all_user');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.user_management.all_user');
    }
}
