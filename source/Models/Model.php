<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Model extends DataLayer
{
    public function __construct()
    {
        parent::__construct("models", ["name", "local_name", "created_by"], 'id', false);
    }
}