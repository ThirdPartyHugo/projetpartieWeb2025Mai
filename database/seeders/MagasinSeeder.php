<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MagasinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('magasins')->insert([
            [
                'nom' => 'Canadian Tire',
                'adresse' => '4100 Bd Josaphat-Rancourt',
                'telephone' => '123-456-7890',
                'longitude' => '12',
                'latitude' => '32',
                'image' => 'canadianTire.jpg'
            ], [
                'nom' => 'Canadian Pire',
                'adresse' => '290 Rue King Ouest',
                'telephone' => '123-456-7321',
                'longitude' => '1223',
                'latitude' => '23321',
                'image' => 'canadianPire.png'

            ], [
                'nom' => 'USA Tire',
                'adresse' => '935 Local 5 Rue Gibraltar',
                'telephone' => '123-123-7890',
                'longitude' => '992',
                'latitude' => '661',
                'image' => 'USATire.png'

            ], [
                'nom' => 'Other Tire',
                'adresse' => '730 Local 4 Bd Bourque',
                'telephone' => '323-882-7890',
                'longitude' => '9212324',
                'latitude' => '31232',
                'image' => 'otherTire.jpg'
            ]
        ]);
    }
}
