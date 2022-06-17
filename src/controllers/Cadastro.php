<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\models\Usuario;

class Cadastro extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['cpf'] = $_POST['cpf'];
        $_SESSION['email'] = $_POST['email'];
        echo $this->renderizarPagina('/cadastro');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->realizarCadastro();
        }
        
    }

    public function realizarCadastro()
    {
        $user = new Usuario($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha']);
        // echo "</br>{$_POST['senha']}";
        echo "</br>{$user->senha}";
        // if(!empty($user)){
        //     echo "opa";
        // }
        
        echo $user->nome;

        $req = [$user->nome, $user->cpf, $user->email, $user->senha];
        $arquivo = fopen('../src/repositorio/usuarios.csv', 'a');
        fputcsv($arquivo, $req, ';');
        fclose($arquivo);
    }
}