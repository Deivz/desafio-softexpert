<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Lista de Produtos</title>
  <style>
    /* Estilos personalizados */
    .navbar {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar-brand:hover {
      color: #0d6efd !important;
    }

    .welcome-message {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
    }

    .nav-link {
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
      background-color: rgba(13, 110, 253, 0.1);
      color: #0d6efd !important;
    }

    .navbar-toggler {
      border: none;
      outline: none;
    }

    .navbar-toggler:focus {
      box-shadow: none;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand welcome-message" href="/produtos">
        <i class="bi bi-shop me-2"></i> Sistema de Mercado
      </a>
      <!-- Botão de Toggle para Mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Itens do Menu -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'produtos' ? 'active' : '' ?>"
              <?= $activePage === 'produtos' ? 'aria-current="page"' : '' ?> href="/produtos">
              <i class="bi bi-box-seam me-1"></i> Produtos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'tipos-produto' ? 'active' : '' ?>"
              <?= $activePage === 'tipos-produto' ? 'aria-current="page"' : '' ?> href="/tipos-produto">
              <i class="bi bi-tags me-1"></i> Tipos de Produto
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $activePage === 'impostos' ? 'active' : '' ?>"
              <?= $activePage === 'impostos' ? 'aria-current="page"' : '' ?> href="/impostos">
              <i class="bi bi-percent me-1"></i> Impostos
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>