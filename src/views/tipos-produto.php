<?php

require __DIR__ . '/../views/topo.php';

?>

<main>
	<div class="container">
		<table class="table table-hover">
			<thead>
				<th>Tipos</th>
			</thead>
			<tbody>
				<?php foreach ($items as $item): ?>
					<tr onclick="window.location='tipos-produto/<?= htmlspecialchars($item['uuid']); ?>'" style="cursor: pointer;">
						<td><?= htmlspecialchars($item['product_type']); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>