<?php

require __DIR__ . '/../views/topo.php';

?>

<main>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <th>Data</th>
                <th>Aplicação</th>
                <th>Operação</th>
                <th>Ativo</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Taxas</th>
            </thead>
            <tbody>
                <?php
                    for($i = 0; $i < $_SESSION['quantidadeDados']; $i++):
                        for($j = 0; $j < count($_SESSION["negociacaoAtivo"][$i]); $j++):
                ?>
                <tr>
                    <td><?= $_SESSION["negociacaoData"][$i] ?></td>
                    <td><?= $_SESSION["negociacaoAplicacao"][$i] ?></td>
                    <td><?= $_SESSION["negociacaoOperacao"][$i][$j] ?></td>
                    <td><?= $_SESSION["negociacaoAtivo"][$i][$j] ?></td>
                    <td><?= $_SESSION["negociacaoQuantidade"][$i][$j] ?></td>
                    <td><?= $_SESSION["negociacaoPreco"][$i][$j] ?></td>
                    <td><?= $_SESSION["negociacaoTaxa"][$i][$j] ?></td>
                </tr>
                <?php
                        endfor;
                    endfor;
                ?>
            </tbody>
        </table>
    </div>

</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>