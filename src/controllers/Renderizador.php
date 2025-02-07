<?php

namespace Deivz\DesafioSoftexpert\controllers;

abstract class Renderizador
{
	public function renderizarPagina(string $caminho): string
	{
		ob_start();
		require "../src/views{$caminho}.php";
		$pagina = ob_get_clean();
		return $pagina;
	}
}
