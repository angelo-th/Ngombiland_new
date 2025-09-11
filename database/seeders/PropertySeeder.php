<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->get();

        if ($users->count() > 0) {
            Property::create([
                'user_id' => $users->first()->id,
                'title' => 'Villa moderne à Bonanjo',
                'description' => 'Magnifique villa de 4 chambres avec jardin et piscine, située dans le quartier résidentiel de Bonanjo. Proche des écoles et commerces.',
                'price' => 75000000,
                'location' => 'Bonanjo, Douala',
                'type' => 'maison',
                'status' => 'approved',
                'latitude' => 4.0483,
                'longitude' => 9.7043,
            ]);

            Property::create([
                'user_id' => $users->first()->id,
                'title' => 'Appartement 3 pièces à Bastos',
                'description' => 'Appartement moderne de 3 pièces avec balcon, situé au 5ème étage avec vue sur la ville. Sécurisé avec gardien 24h/24.',
                'price' => 45000000,
                'location' => 'Bastos, Yaoundé',
                'type' => 'appartement',
                'status' => 'approved',
                'latitude' => 3.8480,
                'longitude' => 11.5021,
            ]);

            Property::create([
                'user_id' => $users->first()->id,
                'title' => 'Terrain constructible 500m²',
                'description' => 'Terrain plat de 500m², idéal pour construction de maison individuelle. Proche des axes routiers principaux.',
                'price' => 15000000,
                'location' => 'Odza, Yaoundé',
                'type' => 'terrain',
                'status' => 'approved',
                'latitude' => 3.9000,
                'longitude' => 11.5500,
            ]);

            Property::create([
                'user_id' => $users->first()->id,
                'title' => 'Bureau commercial à Akwa',
                'description' => 'Bureau de 100m² au rez-de-chaussée, idéal pour commerce ou bureau. Parking disponible.',
                'price' => 25000000,
                'location' => 'Akwa, Douala',
                'type' => 'bureau',
                'status' => 'approved',
                'latitude' => 4.0500,
                'longitude' => 9.7000,
            ]);
        }
    }
}
