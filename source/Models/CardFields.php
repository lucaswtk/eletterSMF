<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class CardFields extends DataLayer
{
    public function __construct()
    {
        parent::__construct('cards_fields', ['id_card', 'name_metadata'], 'id', false);
    }
}