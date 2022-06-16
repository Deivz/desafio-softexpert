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
        if ($this->validarNome($nome)) {
            $this->nome = $nome;
        } else {
            echo "Nome inválido! \n";
            exit;
        }

        if ($this->validarCpf($cpf)){
            $this->cpf = $cpf;
        }else{
            echo "CPF Inválido \n";
            exit;
        }
        
        $this->email = $email;
        $this->senha = $senha = password_hash($senha, PASSWORD_BCRYPT);
    }

    public function __toString()
    {
        return "{$this->nome}\n{$this->cpf}\n{$this->email}";
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function validarNome(string $nome): bool
    {
        return preg_match(
            "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
            $nome,
            $nomeValidado
        );
    }

    public function validarCpf(string $cpf): bool
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function validarEmail(string $nome)
    {
        
    }

    public function validarSenha(string $nome)
    {
    }
}
