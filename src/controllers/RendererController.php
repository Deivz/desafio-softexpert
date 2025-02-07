<?php

namespace Deivz\DesafioSoftexpert\controllers;

abstract class Renderer
{
	public function renderPage(string $path): string
	{
		ob_start();
		require "../src/views{$path}.php";
		$page = ob_get_clean();
		return $page;
	}
}
