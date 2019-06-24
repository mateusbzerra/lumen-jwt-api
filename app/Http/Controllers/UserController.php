<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller{
  public function getAll(){
    return response()->json(User::all());
  }

  public function show($id){
    return response()->json(User::findOrFail($id));
  }

  public function create(Request $request){
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email',
      'password'=>'required'
    ]);
    $hash = Hash::make($request['password']);
    $request['password'] = $hash;
    $input = $request->only(['name','email','password']);
    $user = User::create($input);

    return response()->json($user, 201);
    //return response()->json($request);
  }

  public function update($id, Request $request){
    $user = User::findOrFail($id);
    $user->update($request->all());
    return response()->json($user, 200);
  }

  public function delete($id){
    try{
        User::findOrFail($id)->delete();
        return response()->json(['user'=>'Deleted Successfully'], 200);
    }catch(ModelNotFoundException $e){
        return response()->json(['message'=>'User not found'],404);
    }

  }
}
