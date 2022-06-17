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
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }
}
