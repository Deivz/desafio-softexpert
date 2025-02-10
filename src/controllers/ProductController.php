<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\services\ProductService;

class ProductController extends BaseController
{
	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Product($request);
		$repository = new ProductRepository($this->connection, $this->model);
		$this->service = new ProductService($repository);
	}
}
