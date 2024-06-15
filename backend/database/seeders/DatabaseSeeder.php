<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            'Toyota Camry', 'Honda Accord', 'Ford Mustang', 'Chevrolet Silverado',
            'Volkswagen Golf', 'BMW 3 Series', 'Mercedes-Benz C-Class', 'Audi A4',
            'Subaru Outback', 'Nissan Rogue', 'Hyundai Sonata', 'Kia Sportage',
            'Mazda CX-5', 'Jeep Wrangler', 'Lexus RX', 'Tesla Model S',
            'Volvo XC90', 'Land Rover Range Rover', 'Porsche 911', 'Ferrari 488'
        ];

        $parts = [
            'Engine', 'Transmission', 'Brakes', 'Suspension', 'Tires',
            'Battery', 'Alternator', 'Starter', 'Radiator', 'Exhaust System',
            'Fuel Pump', 'Air Filter', 'Oil Filter', 'Headlights', 'Tail Lights',
            'Door Handles', 'Windows', 'Mirrors', 'Seats', 'Steering Wheel'
        ];

        foreach ($cars as $carName) {
            $car = Car::create([
                'name' => $carName,
                'registration_number' => 'ABC' . rand(100, 999),
                'is_registered' => true,
            ]);

            for ($i = 0; $i < 2; $i++) {
                $part = Part::create([
                    'name' => $parts[array_rand($parts)],
                    'serialnumber' => 'SN' . rand(1000, 9999),
                    'car_id' => $car->id,
                ]);
            }
        }
    }
}
