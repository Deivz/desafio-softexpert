<?php
require __DIR__ . '/../views/topo.php';
?>

<main class="container my-5">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h1 class="h2">Lista de Impostos</h1>
		<a href="/impostos/new" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> Adicionar Novo Imposto
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
		<?php foreach ($items as $item): ?>
			<div class="col-md-4 mb-4">
				<div class="card shadow-sm h-100 position-relative">
					<button onclick="deleteTax('<?= $item['uuid'] ?>')" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" aria-label="Excluir">
						<i class="fas fa-trash text-white"></i>
					</button>
					<div class="card-body">
						<h5 class="card-title"><?= htmlspecialchars($item['product_type']); ?></h5>
						<p>
							<strong>Taxa por produto:</strong> <span id="total-shop"><?php echo number_format($item['tax'] / 100, 1, ',', '.') . "%"; ?></span>
						</p>
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

	<!-- Modal de Confirmação -->
	<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					Tem certeza que deseja excluir este imposto?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
					<button type="button" class="btn btn-danger" id="confirmDeleteButton">
						<span id="buttonText">Sim</span>
						<span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal de Sucesso -->
	<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="successModalLabel">Sucesso</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					Imposto excluído com sucesso!
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="successModalOkButton">OK</button>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	function deleteTax(uuid) {
		const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
		confirmDeleteModal.show();

		const confirmDeleteButton = document.getElementById('confirmDeleteButton');
		const buttonText = document.getElementById('buttonText');
		const buttonSpinner = document.getElementById('buttonSpinner');

		confirmDeleteButton.onclick = () => {
			buttonText.innerText = 'Excluindo...';
			buttonSpinner.classList.remove('d-none');
			confirmDeleteButton.disabled = true;

			fetch(`/impostos/${uuid}`, {
					method: 'DELETE',
					headers: {
						'Content-Type': 'application/json'
					},
				})
				.then(response => {
					if (response.status === 204) {
						confirmDeleteModal.hide();

						const successModal = new bootstrap.Modal(document.getElementById('successModal'));
						successModal.show();

						const successModalOkButton = document.getElementById('successModalOkButton');
						successModalOkButton.onclick = () => {
							window.location.reload();
						};
					} else {
						throw new Error('Erro ao excluir o imposto');
					}
				})
				.catch(error => {
					console.error('Erro:', error);

					alert('Erro ao excluir o imposto. Tente novamente.');
				})
				.finally(() => {
					buttonText.innerText = 'Sim';
					buttonSpinner.classList.add('d-none');
					confirmDeleteButton.disabled = false;
				});
		};
	}
</script>

<?php
require __DIR__ . '/../views/rodape.php';
?>