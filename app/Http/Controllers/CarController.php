<?php

namespace App\Http\Controllers;

use App\Http\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller{
  public function getAll(){
    return response()->json(Car::all());
  }

  public function show($id){
    return response()->json(Car::findOrFail($id));
  }

  public function create(Request $request){
    $this->validate($request, [
      'name' => 'required',
      'color' => 'required',
    ]);
    $car = Car::create($request->all());

    return response()->json($car, 201);
  }

  public function update($id, Request $request){
    $author = Author::findOrFail($id);
    $author->update($request->all());

    return response()->json($author, 200);
  }

  public function delete($id){
    Author::findOrFail($id)->delete();
    return response('Deleted Successfully', 200);
  }
}
