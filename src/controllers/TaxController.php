<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\TaxService;

class TaxController extends BaseController
{
	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Tax($request);
		$repository = new TaxRepository($this->connection, $this->model);
		$this->service = new TaxService($repository);
	}
}
