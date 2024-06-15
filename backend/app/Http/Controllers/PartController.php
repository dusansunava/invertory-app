<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::all()->toArray();
        return response()->json($parts);
        
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'serialnumber' => 'required|string',
            'car_id' => 'integer|nullable',
        ]);

        try {
            $part = Part::findOrFail($id);

            $part->update([
                'name' => $validatedData['name'],
                'serialnumber' => $validatedData['serialnumber'],
                'car_id' => $validatedData['car_id'],
            ]);

            return response()->json($part);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating part.'], 500);
        }
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'serialnumber' => 'required|string',
            'car_id' => 'integer|nullable',
        ]);

        try {
            $partData = [
                'name' => $validatedData['name'],
                'serialnumber' => $validatedData['serialnumber'],
            ];
    
            if (array_key_exists('car_id', $validatedData)) {
                $partData['car_id'] = $validatedData['car_id'];
            }
    
            $part = Part::create($partData);
            return response()->json($part, 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating part.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $part = Part::findOrFail($id);
            $part->delete();

            return response()->json(['message' => 'Part deleted successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting part.'], 500);
        }
    }

    public function getByName($name)
    {
        try {
            $part = Part::where('name', $name)->get();

            if (!$part) {
                return response()->json(['error' => 'Part not found'], 404);
            }

            return response()->json($part, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Part.'], 500);
        }
    }

    public function getBySerialNumber($serialnumber)
    {
        try {
            $part = Part::where('serialnumber', $serialnumber)->get();

            if (!$part) {
                return response()->json(['error' => 'Part not found'], 404);
            }

            return response()->json($part, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Part.'], 500);
        }
    }


    public function getByCarName($carName) 
    {
        try {
            $parts = Part::whereHas('car', function ($query) use ($carName) {
                    $query->where('name', $carName);
                })
                ->get();
    
            if ($parts->isEmpty()) {
                return response()->json(['error' => 'Parts not found for car'], 404);
            }
    
            return response()->json($parts, 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve parts.'], 500);
        }
    }
}
