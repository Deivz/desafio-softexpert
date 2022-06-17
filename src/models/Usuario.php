<?php

namespace Deivz\CalculadoraIr\models;

class Usuario
{
    private $nome;
    private $cpf;
    private $email;
    private $senha;

    public function __construct(string $nome, string $cpf, string $email, string $senha)
    {   
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senha;
        // $this->senha = $senha = password_hash($senha, PASSWORD_BCRYPT);
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    // public function validarNome(string $nome): bool
    // {
    //     if($nome === "" || $nome === null){
    //         echo "</br>O campo nome não pode estar vazio!";
    //             return false;
    //     }
                
    //     if(strlen($nome) > 100){
    //         echo "</br>O campo nome não pode ter mais que 100 caracteres!";
    //         return false;
    //     }
                
    //     if(!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/", $nome, $nomeValidado)){
    //         echo "</br>O campo nome não pode conter números e/ou caracteres matemáticos!";
    //         return false;
    //     }
    //     return true;
    // }

    // public function validarCpf(string $cpf): bool
    // {
    //     // Extrai somente os números
    //     $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        
    //     if ($cpf === "" || $cpf === null){
    //         echo "</br>O campo cpf não pode estar em branco!";
    //         return false;
    //     }

    //     // Verifica se foi informado todos os digitos corretamente
    //     if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)){
    //         echo "</br>CPF inválido!";
    //         return false;
    //     }

    //     // Faz o calculo para validar o CPF
    //     for ($t = 9; $t < 11; $t++) {
    //         for ($d = 0, $c = 0; $c < $t; $c++) {
    //             $d += $cpf[$c] * (($t + 1) - $c);
    //         }
    //         $d = ((10 * $d) % 11) % 10;
    //         if ($cpf[$c] != $d) {
    //             echo "</br>CPF inválido!";
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    // public function validarEmail(string $email): bool
    // {
    //     if($email === "" || $email === null){
    //         echo "</br>O campo email não pode estar vazio!";
    //         return false;
    //     }
                
    //     if($email !== filter_var($email, FILTER_VALIDATE_EMAIL)){
    //         echo "</br>Email inválido!";
    //         return false;
    //     }
    //     return true;
    // }

    // public function validarSenha(string $senha): bool
    // {
    //     $confirmaSenha = $_POST['confirmaSenha'];

    //     if($senha === "" || $senha === null){
    //         echo "</br>O campo senha não pode estar vazio.";
    //         return false;
    //     }
                
    //     if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#])[0-9a-zA-Z$*&@#]{6,}$/", $senha, $senhaValidada)){
    //         echo "</br>A senha deve conter ao menos um número, uma letra maiúscula, uma minúscula, um dos caracteres especiais ($ * & @ #) e no mínimo 6 caracteres!";
    //         return false;
    //     }

    //     if($senha !== $confirmaSenha){
    //         echo "</br>A confirmação de senha difere da senha escolhida.";
    //         return false;
    //     }

    //     return true;
    // }
}
