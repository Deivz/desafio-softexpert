<?php
    require 'topo.php'
?>

    <form class="mt-3 container" action="../controllers/Cadastrar.php" method="post">
        <div class="mb-3">
            <label for="operacao" class="form-label">Operação:</label>
            <input type="text" class="form-control" id="operacao" placeholder="Compra ou venda">
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input type="text" class="form-control" id="valor" placeholder="R$">
        </div>
        <div class="mb-3">
            <label for="data" class="form-label">Data:</label>
            <input type="date" class="form-control" id="data">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

<?php
    require 'rodape.php'
?>