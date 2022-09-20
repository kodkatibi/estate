<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $json = File::get("public/postal-code.json");
        $data = json_decode($json);
        foreach ($data as $obj) {

            if ($obj->fields->country_code == 'GB') {
                Address::query()->create([
                    'postcode' => $obj->fields->postal_code,
                    'latitude' => $obj->fields->latitude,
                    'longitude' => $obj->fields->longitude,
                ]);
            }
        }
        $this->command->info('Country table seeded!');
    }
}
