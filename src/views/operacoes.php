<?php
require 'topo.php';

$aplicacoes = require __DIR__ . '/../helpers/arrayAplicacoes.php';
?>
<form class="mt-3 container" action="operacoes" method="post">
    <div class="mb-3">
        <label for="data" class="form-label">Data:</label>
        <input type="date" class="form-control" id="data">
    </div>
    <div class="mb-3">
        <label class="form-label">Aplicação:</label>
        <select class="form-select" aria-label="Default select example">
            <option selected>Selecione a aplicação</option>
            <!-- Código para preencher o campo de aplicações -->
            <?php
            for ($i = 0; $i < count($aplicacoes); $i++) : ?>
                <option value="<?= $aplicacoes[$i] ?>"><?= $aplicacoes[$i] ?></option>
            <?php endfor ?>
            <!-- fim do preenchimento -->
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Quantidade de operações:</label>
        <select name="quantidadeOperacoes" class="form-select" aria-label="Default select example">
            <option hidden selected><?= $_SESSION['quantidadeOperacoes'] ?></option>
            <!-- Código para preencher o campo de quantidade de operações desejada -->
            <?php
            for ($i = 1; $i <= 10; $i++) : ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
            <!-- fim do preenchimento -->
        </select>
    </div>
    <!-- Código para criar os campos na quantidade de operações desejadas -->
    <?php
        if ($_SESSION['quantidadeOperacoes']) :
    ?> 
    <div class="mb-3">
        <div class="row">
            <label class="form-label col">Ativo:</label>
            <label class="form-label col">Operação:</label>
            <label class="form-label col">Quantidade:</label>
            <label class="form-label col">Preço:</label>
            <label class="form-label col">Taxas:</label>
        </div>
        <!-- Início do loop dos campos -->
        <?php
        for ($i = 1; $i <= $_SESSION['quantidadeOperacoes']; $i++) :
        ?>
            <div class="row">
                <div class="col">
                    <input name="ativo<?= $i ?>" type="text" class="form-control mb-3 me-2 col id="ativo<?= $i ?>" placeholder="Ex: PETR4">
                </div>
                <div class="col">
                    <input name="operacao<?= $i ?>" type="text" class="form-control mb-3 me-2 col id="operacao<?= $i ?>" placeholder="Ex: Compra">
                </div>
                <div class="col">
                    <input name="quantidade<?= $i ?>" type="text" class="form-control mb-3 me-2 col id="quantidade<?= $i ?>" placeholder="Ex: 100...">
                </div>
                <div class="col">
                    <input name="preco<?= $i ?>" type="text" class="form-control mb-3 me-2 col id="preco<?= $i ?>" placeholder="R$">
                </div>
                <div class="col">
                    <input name="taxas<?= $i ?>" type="text" class="form-control mb-3 me-2 col id="taxas<?= $i ?>" placeholder="R$">
                </div>
            </div>
        <?php endfor ?>
        <!-- fim da criação de inputs -->
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    <?php else: ?>
        <button type="submit" class="btn btn-primary">Próximo</button>
    <?php endif ?>
</form>

<?php
require 'rodape.php';
?>