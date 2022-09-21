<?php

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;

class AddressController extends Controller
{
    private AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function show(string $postcode)
    {
        return $this->addressRepository->findByPostCode($postcode);
    }
}
