<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Card extends DataLayer
{
    public function __construct()
    {
        parent::__construct("cards", [
            "card_lot",
            "created_by",
            "receiver_name",
            "receiver_street",
            "receiver_city",
            "receiver_state",
            "receiver_postcode",
            "receiver_neighborhood",
            "receiver_number_address"
        ], 'id', false);
    }
}