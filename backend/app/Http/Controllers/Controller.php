<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        return response()->json(Car::all());
    }

    public function store(Request $request)
    {
        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    public function show($id)
    {
        return response()->json(Car::find($id));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->update($request->all());
        return response()->json($car, 200);
    }

    public function destroy($id)
    {
        Car::destroy($id);
        return response()->json(null, 204);
    }
}
