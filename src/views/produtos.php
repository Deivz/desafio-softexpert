<?php
require __DIR__ . '/../views/topo.php';
?>

<main class="container my-5">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h1 class="h2">Lista de Produtos</h1>
		<a href="/produtos/novo" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> Adicionar Novo Produto
		</a>
	</div>

	<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
		<?php foreach ($items as $item): ?>
			<div class="col">
				<div class="card h-100 shadow-sm" onclick="window.location='produtos/<?= htmlspecialchars($item['uuid']); ?>/venda'" style="cursor: pointer;">
					<div class="card-body">
						<h5 class="card-title"><?= htmlspecialchars($item['name']); ?></h5>
						<p class="card-text">
							<strong>Preço:</strong> R$ <?= number_format($item['price_per_product'], 2, ',', '.'); ?><br>
							<strong>Quantidade Disponível:</strong> <?= htmlspecialchars($item['amount']); ?>
						</p>
					</div>
					<div class="card-footer bg-transparent">
						<small class="text-muted">Clique para ver detalhes</small>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>