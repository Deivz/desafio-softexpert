<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\Sale;
use Deivz\DesafioSoftexpert\repositories\SaleRepository;
use Deivz\DesafioSoftexpert\services\SaleService;

class SaleController extends BaseController
{
	public function __construct(ConnectionController $connection)
	{
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Sale($request);
		$repository = new SaleRepository($connection, $this->model);
		$this->service = new SaleService($repository);
	}
}
