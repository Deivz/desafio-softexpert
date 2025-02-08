<?php

namespace Deivz\DesafioSoftexpert\models;


class ProductTax
{
	private int $tax;

	public function __construct()
	{
		
	}

	public function __get($attribute)
	{
		return $this->$attribute;
	}
}
