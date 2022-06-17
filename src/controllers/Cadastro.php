<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\models\Usuario;
use Error;

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

    private $mensagensDeErro = [
        'nome' => [
            'vazio' => 'O campo nome não pode estar vazio!',
            'invalido' => 'O campo nome não pode conter números e/ou caracteres matemáticos!',
            'minimo' => 'O campo nome não pode ter menos que 2 caracteres!',
            'maximo' => 'O campo nome não pode ter mais que 100 caracteres!'
        ],
    ];

    public function realizarCadastro()
    {
        if($this->validarNome($_POST['nome'])){
            $nome = $_POST['nome'];
        }

        if($this->validarCpf($_POST['cpf'])){
            $cpf = $_POST['cpf'];
        }

        if($this->validarSenha($_POST['senha'])){
            $senha = $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
        }

        if($this->validarEmail($_POST['email'])){
            $email = $_POST['email'];
        }

        $user = new Usuario($nome, $cpf, $senha, $email);

        $req = [$user->nome, $user->cpf, $user->senha, $user->email];

        $arquivo = fopen('../src/repositorio/usuarios.csv', 'a');
        fputcsv($arquivo, $req, ';');
        fclose($arquivo);
        header('Location: /login');
    }

    public function validarNome(string $nome): bool
    {
        if($nome === "" || $nome === null){
            echo "</br>";
            return false;
        }
                
        if(strlen($nome) > 100){
            echo "</br>";
            return false;
        }
                
        if(!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $nome, $nomeValidado)){
            echo "</br>";
            return false;
        }
        return true;
    }

    public function validarCpf(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        
        if ($cpf === "" || $cpf === null){
            echo "</br>O campo cpf não pode estar em branco!";
            return false;
        }

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)){
            echo "</br>CPF inválido!";
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                echo "</br>CPF inválido!";
                return false;
            }
        }
        return true;
    }

    public function validarEmail(string $email): bool
    {
        if($email === "" || $email === null){
            echo "</br>O campo email não pode estar vazio!";
            return false;
        }
                
        if($email !== filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "</br>Email inválido!";
            return false;
        }
        return true;
    }

    public function validarSenha(string $senha): bool
    {
        $confirmaSenha = $_POST['confirmaSenha'];

        if($senha === "" || $senha === null){
            echo "</br>O campo senha não pode estar vazio.";
            return false;
        }
                
        if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/", $senha, $senhaValidada)){
            echo "</br>A senha deve conter ao menos um número, uma letra maiúscula, uma minúscula, um dos caracteres especiais ($ * & @ #) e no mínimo 6 caracteres!";
            return false;
        }

        if($senha !== $confirmaSenha){
            echo "</br>A confirmação de senha difere da senha escolhida.";
            return false;
        }

        return true;
    }
}