<?php

namespace Deivz\DesafioSoftexpert\models;


class ProductType
{
	private string $type;

	public function __construct()
	{
		
	}

	public function __get($attribute)
	{
		return $this->$attribute;
	}
}
