<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all()->toArray();
        return response()->json($cars);   
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'is_registered' => 'required|boolean',
            'registration_number' => $request->input('is_registered') ? 'required|string' : '', 
        ]);

        try {

            $registrationNumber = $validatedData['is_registered'] ? $validatedData['registration_number'] : "";
            $car = Car::findOrFail($id);
            $car->update([
                'name' => $validatedData['name'],
                'registration_number' => $registrationNumber,
                'is_registered' => $validatedData['is_registered'],
            ]);

            return response()->json($car);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating car.'], 500);
        }
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'is_registered' => 'required|boolean',
            'registration_number' => $request->input('is_registered') ? 'required|string' : '', 
        ]);
    
        try {

            $registrationNumber = $validatedData['is_registered'] ? $validatedData['registration_number'] : "";

            $car = Car::create([
                'name' => $validatedData['name'],
                'registration_number' => $registrationNumber,
                'is_registered' => $validatedData['is_registered'],
            ]);
    
            return response()->json($car, 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating car.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();

            return response()->json(['message' => 'Car deleted successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting car.'], 500);
        }
    }

    public function getByName($name)
    {
        try {
            $car = Car::where('name', $name)->get();

            if (!$car) {
                return response()->json(['error' => 'Car not found'], 404);
            }

            return response()->json($car, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve car.'], 500);
        }
    }

    public function getByRegistrationNumber($registration_number)
    {
        try {
            $car = Car::where('registration_number', $registration_number)->get();

            if (!$car) {
                return response()->json(['error' => 'Car not found'], 404);
            }

            return response()->json($car, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve car.'], 500);
        }
    }

    public function getByIsRegistered($is_registered)
    {
        try {
            $car = Car::where('is_registered', $is_registered)->get();

            if (!$car) {
                return response()->json(['error' => 'Car not found'], 404);
            }

            return response()->json($car, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve car.'], 500);
        
    }
    }
}


?>