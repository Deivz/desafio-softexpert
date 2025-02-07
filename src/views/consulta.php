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
				if (isset($_SESSION['negociacoes'][0])):
					for ($i = 0; $i < $_SESSION['quantidadeDados']; $i++):
						extract($_SESSION['negociacoes'][$i]);
						for ($j = 0; $j < count($ativos); $j++):
				?>
							<tr>
								<td><?= $data ?></td>
								<td><?= $aplicacao ?></td>
								<td><?= $ativos[$j] ?></td>
								<td><?= $operacoes[$j] ?></td>
								<td><?= $quantidades[$j] ?></td>
								<td><?= 'R$' . str_replace('.', ',', $precos[$j]) ?></td>
								<td><?= 'R$' . str_replace('.', ',', $taxas[$j]) ?></td>
								<td class="col-sm-2">
									<a href="/excluir-operacao?id=<?= $id ?>"><button type="button" class="btn-sm btn-danger">Excluir</button></a>
								</td>
							</tr>
				<?php
						endfor;
						unset($_SESSION['negociacoes'][$i]);
					endfor;
				endif;
				?>
			</tbody>
		</table>
	</div>

</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>