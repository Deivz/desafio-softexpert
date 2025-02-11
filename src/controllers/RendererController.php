<?php

namespace Deivz\DesafioSoftexpert\controllers;

abstract class RendererController
{
	public function renderPage(string $path, array $data = []): string
	{
		extract($data);
		ob_start();
		require "../src/views{$path}.php";
		$page = ob_get_clean();
		return $page;
	}
}
