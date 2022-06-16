<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <form class="mt-3 container" action="../controllers/Cadastrar.php" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome completo*</label>
            <input type="text" class="form-control" id="nome" placeholder="Nome completo">
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF*</label>
            <input type="text" class="form-control" id="cpf" placeholder="CPF somente números">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" class="form-control" id="email" placeholder="nome@exemplo.com">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha*</label>
            <input type="password" class="form-control" id="senha">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>