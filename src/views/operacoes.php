<?php
require 'topo.php';

$aplicacoes = require __DIR__ . '/../helpers/arrayAplicacoes.php';
$titulos = require __DIR__ . '/../helpers/labelTitulos.php';
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
            <option selected>Selecione a quantidade de operações:</option>
            <!-- Código para preencher o campo de quantidade de operações desejada -->
            <?php
            for ($i = 1; $i < 11; $i++) : ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php
            endfor;
            $_SESSION['quantidadeOperacoes'] = $_POST['quantidadeOperacoes'];
            ?>
            <!-- fim do preenchimento -->
        </select>
    </div>
    <div class="mb-3">
        
            
            
        <!-- Código para criar os campos na quantidade de operações desejadas -->
        <?php
            if ($_SESSION['segundaEtapa']) :
        ?> 
            <div class="row">
                <!-- Código para preencher os títulos das labels -->
                <?php
                    for ($i = 0; $i < count($titulos); $i++) :
                ?>
                    <label class="form-label col"><?= $titulos[$i] ?>:</label>
                <?php endfor ?>
                <!-- fim do preenchimento -->
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
        <?php
            endfor;
        endif;
        ?>
        <!-- fim da criação de inputs -->
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
    <?php unset($_SESSION['quantidadeOperacoes']) ?>
</form>

<?php
require 'rodape.php';
?>