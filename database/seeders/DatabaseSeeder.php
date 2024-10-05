<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\OrganizationProfile;
use App\Models\Representative;
use App\Models\RepresentativeArea;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            ServiceSeeder::class,
            AreaSeeder::class,
            SubAreaSeeder::class,
            TransactionsTypesSeeder::class,
            serialSettingsSeeder::class,
            OrganizationProfileSeeder::class,
            SettingsSeeder::class,
        ]);
        $representive = Representative::create([
            'is_approved' => 1,
            'email' => 'msctesteremail@themsc.net',
            'fullname' => 'deriverGeust',
            'phone' => '+249 0915477450',
            'area_id' => 1,
            'sub_area_id' => 1,
        ]);
        RepresentativeArea::create([
            'representative_id' => $representive->id,
            'subarea_id' => 2,
        ]);
        RepresentativeArea::create([
            'representative_id' => $representive->id,
            'subarea_id' => 1,
        ]);
        RepresentativeArea::create([
            'representative_id' => $representive->id,
            'subarea_id' => 3,
        ]);

        Client::factory(2)->create();
    }
}