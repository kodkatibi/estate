<?php

namespace App\Repositories;

use App\Interfaces\AddressInterface;
use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AddressRepository implements AddressInterface
{

    public function create(array $data)
    {
        return Address::create($data);
    }

    public function delete(int $id)
    {
        $address = Address::find($id);
        return $address->delete();
    }

    public function find(int $id)
    {
        return Address::find($id);
    }

    public function all()
    {
        return Address::all();
    }

    public function getDataFromApi(string $postcode)
    {
        Str::replace(' ', '+', $postcode);

        $url = 'http://api.getthedata.com/postcode/' . $postcode;

        $response = Http::get($url);

        $data = $response->json();
        if ($data['status'] == 'match' && $data['match_type'] == 'unit_postcode') {
            $data = $data['data'];
            return $this->create([
                'postcode' => $data['postcode'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        }

        return [];
    }

    public function findByPostCode(string $postcode)
    {
        $address = Address::where('postcode', $postcode)->first();
        return $address ?? $this->getDataFromApi($postcode);
    }
}

