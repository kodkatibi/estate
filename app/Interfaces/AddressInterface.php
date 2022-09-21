<?php

namespace App\Interfaces;

interface AddressInterface
{
    public function create(array $data);

    public function delete(int $id);

    public function find(int $id);

    public function all();

    public function findByPostCode(string $postcode);

    function getDataFromApi(string $postcode);

}
