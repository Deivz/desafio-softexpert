<?php

namespace Deivz\CalculadoraIr\models;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IValidacao;

class Usuario implements IValidacao
{
    use TVerificarErros;

    private $nome;
    private $cpf;
    private $email;
    private $senha;

    public function __construct(string $nome, string $cpf, string $email, string $senha)
    {   
        if($this->validarNome($nome)){
            $this->nome = $nome;
        }

        if($this->validarCpf($cpf)){
            $this->cpf = $cpf;
        }

        if($this->validarEmail($email)){
            $this->email = $email;
        }
        
        if($this->validarSenha($senha)){
            $this->senha = password_hash($senha, PASSWORD_BCRYPT);
        }

        $this->verificarValidacao();
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    private function validarNome($nome):bool
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
        return true;;
    }
    
    private function validarCpf($cpf):bool
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

    public function verificarValidacao()
    {
        if($_SESSION['erros'] === 1){
            header('Location: /cadastro');
            exit();
        }
    }
}
