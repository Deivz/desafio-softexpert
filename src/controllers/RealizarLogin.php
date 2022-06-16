<?php

use Deivz\CalculadoraIr\controllers\Login;

$usuario = new Login();
$usuario->realizarLogin();

if(!$_SESSION['logado']){
    echo "Falha no login!";
    exit();
}
echo "Login realizado com sucesso!";