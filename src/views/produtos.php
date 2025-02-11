<?php

require __DIR__ . '/../views/topo.php';

?>

<main>
	<div class="container">
		<table class="table table-hover">
			<thead>
				<th>Produto</th>
				<th>Preço</th>
				<th>Quantidade Disponível</th>
			</thead>
			<tbody>
				<?php foreach ($items as $item): ?>
					<tr onclick="window.location='produtos/<?= htmlspecialchars($item['uuid']); ?>/venda'" style="cursor: pointer;">
						<td><?= htmlspecialchars($item['name']); ?></td>
						<td>R$<?php echo number_format($item['price_per_product'], 2, ',', '.'); ?></td>
						<td><?= htmlspecialchars($item['amount']); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>