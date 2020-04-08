<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer
{
	public function __construct()
	{
		parent::__construct("users", ["name", "registration", "password", "organ"], 'id', false);
	}

	public function save(): bool
	{
		$user = (new User())->find('registration = :reg', 'reg=' . $this->registration)->fetch();

		if ($user) {
			echo 'Esta matrícula já existe!';
			return false;
		}

		return parent::save();
	}
}