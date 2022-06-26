<?php
require 'topo.php';

$aplicacoes = require __DIR__ . '/../helpers/arrayAplicacoes.php';
$operacoes = require __DIR__ . '/../helpers/arrayOperacoes.php';
?>

<?php
    if(isset($_SESSION['sucesso'])):
?>
    <div class="container mt-3 alert alert-success">
        <?= $_SESSION['sucesso'] ?>
    </div>
    
<?php
    endif;
?>

<?php
    if(isset($_SESSION['mensagens'])):
        foreach ($_SESSION['mensagens'] as $mensagem) :
?>
    <div class="container mt-3 alert alert-danger">
        <?= $mensagem ?>
    </div>
    
<?php
    endforeach;
    endif;
?>

<main>
    <form class="mt-3 container" action="operacoes" method="post">
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
        
        
        <?php
            if ($_SESSION['quantidadeOperacoes']) :
        ?> 
        <!-- Código para criar os campos na quantidade de operações desejadas -->
        <div class="d-flex justify-content-between">
            <div class="mb-3 me-2 col">
                <label for="data" class="form-label">Data:</label>
                <input value="<?= $_SESSION['data'] ?>" name="data" type="date" class="form-control" id="data" maxlength="10">
            </div>
            <div class="mb-3 ms-2 col">
                <label class="form-label">Aplicação:</label>
                <select name="aplicacao" class="form-select" aria-label="Default select example">
                    <option hidden selected><?= $_SESSION['aplicacao'] ?></option>
                    <!-- Código para preencher o campo de aplicações -->
                    <?php
                    for ($i = 0; $i < count($aplicacoes); $i++) : ?>
                        <option value="<?= $aplicacoes[$i] ?>"><?= $aplicacoes[$i] ?></option>
                    <?php endfor ?>
                    <!-- fim do preenchimento -->
                </select>
            </div>
        </div>
        
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
            for ($i = 0; $i < $_SESSION['quantidadeOperacoes']; $i++) :
            ?>
                <div class="row">
                    <div class="col">
                        <input value="<?= $_SESSION["ativo{$i}"] ?>" name="ativo<?= $i ?>" type="text" class="form-control mb-3 me-2 col" id="ativo<?= $i ?>" placeholder="Ex: PETR4" maxlength="7">
                    </div>
                    <div class="col">
                        <select name="operacao<?= $i ?>" class="form-select" aria-label="Default select example">
                            <option hidden selected><?= $_SESSION["operacao{$i}"] ?></option>
                            <!-- Código para preencher o campo de aplicações -->
                            <?php
                            for ($j = 0; $j < count($operacoes); $j++) : ?>
                                <option value="<?= $operacoes[$j] ?>"><?= $operacoes[$j] ?></option>
                            <?php endfor ?>
                            <!-- fim do preenchimento -->
                        </select>
                    </div>
                    <div class="col">
                        <input value="<?= $_SESSION["quantidade{$i}"] ?>" name="quantidade<?= $i ?>" type="text" class="form-control mb-3 me-2 col" id="quantidade<?= $i ?>" placeholder="Ex: 100..." maxlength="7">
                    </div>
                    <div class="col">
                        <input value="<?= $_SESSION["preco{$i}"] ?>" name="preco<?= $i ?>" type="text" class="form-control mb-3 me-2 col" id="preco<?= $i ?>" placeholder="R$" maxlength="7">
                    </div>
                    <div class="col">
                        <input value="<?= $_SESSION["taxa{$i}"] ?>" name="taxa<?= $i ?>" type="text" class="form-control mb-3 me-2 col" id="taxa<?= $i ?>" placeholder="R$" maxlength="5">
                    </div>
                </div>
            <?php endfor ?>
            <!-- fim da criação de inputs -->
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <?php else: ?>
            <button type="submit" class="btn btn-primary">Próximo</button>
        <?php
            endif;
        ?>

    <?php
        $removerSessoes = require __DIR__ . '/../helpers/removerSessoes.php';

        $removerSessoes($_SESSION['quantidadeOperacoes']);

        unset($_SESSION['mensagens']);
        unset($_SESSION['sucesso']);
        unset($_SESSION['erros']);
    ?>
    </form>
</main>

<?php
require 'rodape.php';
?>