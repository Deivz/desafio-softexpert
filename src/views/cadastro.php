<?php
    require 'topo.php';
?>
<?php
    $erros = require '../helpers/erros.php';
    foreach($erros as $erro) : ?>
        <div class="container mt-3 alert alert-danger">
            Mensagem
        </div>
<?php endforeach ?>

<form class="mt-3 container" action="cadastro" method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome completo*</label>
        <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome completo" maxlength="100" value="<?= $_SESSION['nome']?>">
    </div>
    <div class="mb-3">
        <label for="cpf" class="form-label">CPF*</label>
        <input name="cpf" type="text" class="form-control" id="cpf" placeholder="CPF somente números" maxlength="14" value="<?= $_SESSION['cpf'] ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email*</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="nome@exemplo.com" maxlength="50" value="<?= $_SESSION['email'] ?>">
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha*</label>
        <input name="senha" type="password" class="form-control" id="senha" maxlength="50">
    </div>
    <div class="mb-3">
        <label for="confirmaSenha" class="form-label">Confirmar senha*</label>
        <input name="confirmaSenha" type="password" class="form-control" id="confirmaSenha" maxlength="50">
    </div>
    <button type="submit" id="submit" class="btn btn-primary">Cadastrar</button>
    
</form>

<?php
    require 'rodape.php';
?>