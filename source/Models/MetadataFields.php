<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class MetadataFields extends DataLayer
{
    public function __construct()
    {
        parent::__construct("metadata_fields", ["model_id", "metadata_id"], 'id', false);
    }
}