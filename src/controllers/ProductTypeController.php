<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PDO;

class ProductTypeController extends BaseController
{
	public function __construct(ConnectionController $connection)
	{
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new ProductType($request);
		$repository = new ProductTypeRepository($connection, $this->model);
		$this->service = new ProductTypeService($repository);
	}
}
