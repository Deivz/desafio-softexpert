<?php

namespace Deivz\DesafioSoftexpert\models;


class Product
{
	private string $name;
	private int $price;

	public function __construct()
	{
		
	}

	public function __get($attribute)
	{
		return $this->$attribute;
	}
}
