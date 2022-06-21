<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\helpers\TMensagensDeErro;
use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\interfaces\ISessoes;
use Deivz\CalculadoraIr\models\Usuario;
use Error;

class Cadastro extends Renderizador implements IRequisicao, ISessoes
{
    use TMensagensDeErro;

    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/cadastro');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->realizarCadastro();
        }
    }

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

        try{
            $user = new Usuario($nome, $cpf, $email, $senha);
        }catch(Error $err){
            $this->definirSessoes();
            header('Location: /cadastro');
            exit();
        }

        $req = [
            'nome' => $user->nome,
            'cpf' => $user->cpf,
            'senha' => $user->senha,
            'email' => $user->email
        ];

        $dados = "\n" . json_encode($req);
        $arquivo = fopen('../src/repositorio/usuarios.txt', 'a');
        fwrite($arquivo, $dados);
        fclose($arquivo);
        $_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
        header('Location: /login');
    }

    public function definirSessoes()
    {
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['cpf'] = $_POST['cpf'];
        $_SESSION['email'] = $_POST['email'];
    }

    public function validarNome(string $nome): bool
    {
        if($nome === "" || $nome === null){
            $this->mostrarMensagensDeErro('O campo nome não pode estar vazio!');
            return false;
        }
                
        if(strlen($nome) > 100){
            $this->mostrarMensagensDeErro('O campo nome pode possuir mais que 100 caracteres!');
            return false;
        }
                
        if(!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $nome, $nomeValidado)){
            $this->mostrarMensagensDeErro('O campo nome não pode conter números e/ou caracteres matemáticos!');
            return false;
        }
        return true;
    }

    public function validarCpf(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        
        if ($cpf === "" || $cpf === null){
            // $_SESSION['erro'] = 'O campo CPF não pode estar vazio!';
            $this->mostrarMensagensDeErro('O campo CPF não pode estar vazio!');
            return false;
        }

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)){
            $this->mostrarMensagensDeErro('CPF inválido!');
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $this->mostrarMensagensDeErro('CPF inválido!');
                return false;
            }
        }
        return true;
    }

    public function validarEmail(string $email): bool
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

        if($email === "" || $email === null){
            $this->mostrarMensagensDeErro('O campo email não pode estar vazio!');
            return false;
        }
                
        if($email !== filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->mostrarMensagensDeErro('Email inválido!');
            return false;
        }
        return true;
    }

    public function validarSenha(string $senha): bool
    {
        $confirmaSenha = $_POST['confirmaSenha'];

        if($senha === "" || $senha === null){
            $this->mostrarMensagensDeErro('O campo senha não pode estar vazio.');
            return false;
        }
                
        if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/", $senha, $senhaValidada)){
            $this->mostrarMensagensDeErro('A senha deve conter ao menos um número, uma letra maiúscula, uma minúscula, um dos caracteres especiais ($ * & @ #) e no mínimo 6 caracteres!');
            return false;
        }

        if($senha !== $confirmaSenha){
            $this->mostrarMensagensDeErro('A confirmação de senha difere da senha escolhida.');
            return false;
        }

        return true;
    }
}