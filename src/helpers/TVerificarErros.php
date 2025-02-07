<?php

namespace Deivz\DesafioSoftexpert\helpers;

trait TVerificarErros
{
  private function mostrarMensagensDeErro(string $mensagem)
  {
    static $mensagens = [];
    if (!in_array($mensagem, $mensagens)) {
      array_push($mensagens, $mensagem);
      $_SESSION['mensagens'] = $mensagens;
    }

    if (count($mensagens) !== 0) {
      $_SESSION['erros'] = 1;
    }
  }
}
