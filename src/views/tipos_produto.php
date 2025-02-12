<?php
require __DIR__ . '/../views/topo.php';
?>

<main class="container my-5">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h1 class="h2">Tipos de Produto</h1>
		<a href="/tipos_produto/new" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> Adicionar Novo Tipo
		</a>
	</div>

	<form method="GET" class="mb-3">
		<label for="limit">Itens por página:</label>
		<select name="limit" id="limit" class="form-select d-inline w-auto" onchange="this.form.submit()">
			<option value="6" <?= $limit == 6 ? 'selected' : '' ?>>6</option>
			<option value="9" <?= $limit == 9 ? 'selected' : '' ?>>9</option>
			<option value="12" <?= $limit == 12 ? 'selected' : '' ?>>12</option>
		</select>
		<input type="hidden" name="page" value="1">
	</form>

	<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
		<?php if (empty($items)): ?>
			<div class="col-12 w-100">
				<div class="alert alert-info" role="alert">
					Nenhum tipo de produto cadastrado.
				</div>
			</div>
		<?php endif; ?>
		<?php foreach ($items as $item): ?>
			<div class="col-md-4 mb-4">
				<div class="card shadow-sm h-100 position-relative">
					<!-- Botão de editar no topo direito -->
					<a href="tipos_produto/<?= htmlspecialchars($item['uuid']); ?>/edit" class="btn btn-primary btn-sm position-absolute top-0 end-0 m-2" aria-label="Editar">
						<i class="fas fa-pen text-white"></i>
					</a>
					<div class="card-body">
						<h5 class="card-title"><?= htmlspecialchars($item['product_type']); ?></h5>
						<!-- <p class="card-text text-muted">Descrição ou detalhes adicionais podem ser colocados aqui.</p> -->
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Paginação -->
	<nav aria-label="Navegação da página" class="mt-4">
		<ul class="pagination justify-content-center">
			<?php if ($page > 1): ?>
				<li class="page-item">
					<a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>">Anterior</a>
				</li>
			<?php endif; ?>

			<?php for ($i = 1; $i <= $totalPages; $i++): ?>
				<li class="page-item <?= $i == $page ? 'active' : '' ?>">
					<a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
				</li>
			<?php endfor; ?>

			<?php if ($page < $totalPages): ?>
				<li class="page-item">
					<a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Próximo</a>
				</li>
			<?php endif; ?>
		</ul>
	</nav>

</main>

<?php
require __DIR__ . '/../views/rodape.php';
?>