<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface IRequisicao
{
	public function processRequest(string $method, string $resource = null): void;
}
