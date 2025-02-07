<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\TVerificarErros;
use Deivz\DesafioSoftexpert\interfaces\IRequisicao;
use Deivz\DesafioSoftexpert\interfaces\IValidacao;
use Deivz\DesafioSoftexpert\models\Usuario;
use Error;

class Cadastro extends Renderizador implements IRequisicao, IValidacao
{
	use TVerificarErros;

	public function processarRequisicao(): void
	{
		echo $this->renderizarPagina('/cadastro');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->realizarCadastro($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha']);
		}
	}

	private function realizarCadastro($nome, $cpf, $email, $senha)
	{
		$_SESSION['dadosUsuario'] = compact('nome', 'cpf', 'email');

		if (!$this->verificarDuplicidade($cpf, $email)) {
			$this->verificarValidacao();
		}

		$user = new Usuario($nome, $cpf, $email, $senha);

		$req = [
			'nome' => $user->nome,
			'cpf' => $user->cpf,
			'email' => $user->email,
			'senha' => $user->senha
		];

		$dados = "\n" . json_encode($req, JSON_UNESCAPED_UNICODE);
		$arquivo = fopen('../src/infraestrutura/persistencia/usuarios.txt', 'a');
		fwrite($arquivo, $dados);
		fclose($arquivo);
		$_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
		unset($_SESSION['dadosUsuario']);
		header('Location: /login');
	}

	private function verificarDuplicidade($cpf, $email): bool
	{
		$arquivo = '../src/infraestrutura/persistencia/usuarios.txt';
		$stream = fopen($arquivo, 'r');
		while (!feof($stream)) {
			$usuario = json_decode(fgets($stream));
			if ($cpf === $usuario->{'cpf'}) {
				$this->mostrarMensagensDeErro('CPF já cadastrado no sistema!');
				return false;
			}

			if ($email === $usuario->{'email'}) {
				$this->mostrarMensagensDeErro('Email já cadastrado no sistema!');
				return false;
			}
		}
		fclose($stream);
		return true;
	}

	public function verificarValidacao()
	{
		if ($_SESSION['erros'] === 1) {
			header('Location: /cadastro');
			exit();
		}
	}
}
