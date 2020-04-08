<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Metadata extends DataLayer
{
    public function __construct()
    {
        parent::__construct("metadata", ["name", "description", "type"], 'id', false);
    }
}