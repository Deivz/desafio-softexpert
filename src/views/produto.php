<?php
require __DIR__ . '/../views/topo.php';
?>

<main>
	<div class="container my-5">
		<h1 class="text-center mb-4">Carrinho de Compras</h1>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-sm">
					<div class="card-body">
						<h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
						<p class="card-text">
							<strong>Preço Unitário:</strong> R$<?php echo number_format($item['price_per_product'], 2, ',', '.'); ?><br>
							<strong>Quantidade Disponível:</strong> <?php echo htmlspecialchars($item['amount']); ?><br>
						</p>
						<div class="d-flex justify-content-between align-items-center mb-3">
							<button class="btn btn-outline-danger btn-sm" onclick="updateAmount(-1)" <?php echo $item['amount'] == 0 ? 'disabled' : ''; ?>>
								<i class="bi bi-dash"></i>
							</button>
							<span id="amount" class="mx-2"><?php echo $item['amount'] == 0 ? 0 : 1; ?></span>
							<button class="btn btn-outline-success btn-sm" onclick="updateAmount(1)" <?php echo $item['amount'] == 0 ? 'disabled' : ''; ?>>
								<i class="bi bi-plus"></i>
							</button>
						</div>
						<p>
							<strong>Valor da Compra:</strong> R$<span id="total-shop"><?php echo number_format($item['price_per_product'], 2, ',', '.'); ?></span>
						</p>
						<p>
							<strong>Total de Impostos:</strong> R$<span id="total-tax"><?php echo number_format($item['tax_price'], 2, ',', '.'); ?></span>
						</p>
						<button class="btn btn-primary w-100" onclick="buy()" id="buyButton" <?php echo $item['amount'] == 0 ? 'disabled' : ''; ?>>
							<?php if ($item['amount'] == 0): ?>
								Produto Indisponível
							<?php else: ?>
								<span id="buttonText">Comprar</span>
								<span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
							<?php endif; ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- Modal para exibir mensagens -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="messageModalLabel">Mensagem</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p id="modalMessage"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="redirectButton">OK</button>
			</div>
		</div>
	</div>
</div>

<script>
	const uuid = <?php echo json_encode($item['uuid']); ?>;
	const price = <?php echo json_encode($item['price_per_product']); ?>;
	const taxPrice = <?php echo json_encode($item['tax_price']); ?>;
	const maxAmount = <?php echo json_encode($item['amount']); ?>;
	let amount = <?php echo $item['amount'] == 0 ? 0 : 1; ?>;

	function updateAmount(change) {
		amount += change;

		if (amount < 1) amount = 1;
		if (amount > maxAmount) amount = maxAmount;

		document.getElementById('amount').innerText = amount;

		const totalShop = price * amount;
		document.getElementById('total-shop').innerText = totalShop.toFixed(2).replace('.', ',');

		const totalTax = taxPrice * amount;
		document.getElementById('total-tax').innerText = totalTax.toFixed(2).replace('.', ',');

		document.querySelector('.btn-outline-success').disabled = amount >= maxAmount;
	}

	function buy() {
		const buyButton = document.getElementById('buyButton');
		const buttonText = document.getElementById('buttonText');
		const buttonSpinner = document.getElementById('buttonSpinner');

		buyButton.disabled = true;
		buttonText.innerText = 'Processando...';
		buttonSpinner.classList.remove('d-none');

		const data = {
			amount: amount,
		};

		fetch(`/produtos/${uuid}/venda`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(result => {
				const modalMessage = document.getElementById('modalMessage');
				modalMessage.innerText = result.mensagem;

				const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
				messageModal.show();

				const redirectButton = document.getElementById('redirectButton');
				redirectButton.onclick = () => {
					window.location.href = '/produtos';
				};
			})
			.catch(error => {
				console.error('Erro:', error);

				const modalMessage = document.getElementById('modalMessage');
				modalMessage.innerText = 'Erro ao processar a compra. Tente novamente.';

				const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
				messageModal.show();
			})
			.finally(() => {
				buyButton.disabled = false;
				buttonText.innerText = 'Comprar';
				buttonSpinner.classList.add('d-none');
			});
	}
</script>

<?php
require __DIR__ . '/../views/rodape.php';
?>