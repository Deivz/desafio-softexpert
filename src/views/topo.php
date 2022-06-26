<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Calculadora de operações em Bolsa de Valores</title>
</head>

<body>
  <?php if (!isset($_SESSION['logado'])) : ?>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
      <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/cadastro">Cadastro</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  <?php endif ?>

  <?php if (isset($_SESSION['logado'])) : ?>
    <nav class="navbar navbar-expand-lg navbar-light d-flex flex-wrap" style="background-color: #e3f2fd;">
      <div class="container-md">
        <h2>Bem vindo, <?= $_SESSION['nomeUsuario'] ?></h2>
      </div>
      <div class="container">
        <div class="d-flex justify-content-between">
          <div class="me-4">
            <a class="navbar-brand" href="/operacoes">Lançar operações</a>
          </div>
          <div>
            <a class="navbar-brand" href="/operacoes/lista">Listar operações</a>
          </div>
        </div>

        <div class="d-flex">
          <li class="nav-item form-control">
            <a class="nav-link" href="/logout">Sair</a>
        </div>
      </div>
      </div>
    </nav>
  <?php endif ?>