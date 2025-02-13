<?php
require __DIR__ . '/../views/topo.php';
?>

<main class="container my-5">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white">
					<h5 class="card-title mb-0">Cadastrar Novo Produto</h5>
				</div>
				<div class="card-body">
					<form id="formProduto" novalidate>
						<div class="mb-3">
							<label for="name" class="form-label">Nome do Produto*</label>
							<input type="text" class="form-control" id="name" name="name" required aria-required="true">
							<div class="invalid-feedback" id="nameError"></div>
						</div>
						<div class="mb-3">
							<label for="amount" class="form-label">Quantidade*</label>
							<input type="number" class="form-control" id="amount" name="amount" min="0" required aria-required="true">
							<div class="invalid-feedback" id="amountError"></div>
						</div>
						<div class="mb-3">
							<label for="price" class="form-label">Preço*</label>
							<input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required aria-required="true">
							<div class="invalid-feedback" id="priceError"></div>
						</div>
						<div class="mb-3">
							<label for="product_type" class="form-label">Tipo de Produto*</label>
							<select class="form-select" id="product_type" name="product_type" required aria-required="true">
								<?php if (empty($productTypes)): ?>
									<option value="" disabled selected>Nenhum tipo de produto encontrado</option>
								<?php endif; ?>
								<?php if (!empty($productTypes)): ?>
									<option value="" disabled selected>Selecione um tipo</option>
									<?php foreach ($productTypes as $type): ?>
										<option value="<?= htmlspecialchars($type['id']); ?>"><?= htmlspecialchars($type['name']); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<div class="invalid-feedback" id="product_typeError"></div>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary" id="submitButton">
								<span id="buttonText">Salvar</span>
								<span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Modal de Sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="successModalLabel">Sucesso</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p id="successMessage"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal de Aviso -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-warning text-white">
				<h5 class="modal-title" id="warningModalLabel">Aviso</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p id="warningMessage"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<script>
	// Funções de validação
	const validations = {
		required: (value) => !value ? "Este campo é obrigatório." : null,
		maxLength: (value) => value.length > 255 ? "Este campo deve possuir no máximo 255 caracteres." : null,
		int: (value) => !Number.isInteger(Number(value)) ? "O valor deste campo deve ser um número inteiro." : null,
		positiveNumber: (value) => value < 0 ? "O valor deste campo deve ser um número maior que 0." : null,
		maxNumber: (value) => value > 100000000 ? "Este campo não deve possuir valor maior que 100.000.000." : null,
	};

	function validateField(field, rules) {
		const value = field.value;
		let error = null;

		for (const rule of rules) {
			error = validations[rule](value);
			if (error) break;
		}

		return error;
	}

	function showError(fieldId, error) {
		const errorElement = document.getElementById(`${fieldId}Error`);
		const inputElement = document.getElementById(fieldId);

		if (error) {
			errorElement.innerHTML = error.split('. ').join('.<br>');
			if (inputElement) inputElement.classList.add('is-invalid');
		} else {
			errorElement.textContent = '';
			if (inputElement) inputElement.classList.remove('is-invalid');
		}
	}

	function validateForm() {
		const fields = [{
				id: 'name',
				rules: ['required', 'maxLength']
			},
			{
				id: 'amount',
				rules: ['required', 'int', 'positiveNumber', 'maxNumber']
			},
			{
				id: 'price',
				rules: ['required', 'positiveNumber', 'maxNumber']
			},
			{
				id: 'product_type',
				rules: ['required', 'int', 'positiveNumber']
			},
		];

		let isValid = true;

		fields.forEach(({
			id,
			rules
		}) => {
			const field = document.getElementById(id);
			const error = validateField(field, rules);
			showError(id, error);
			if (error) isValid = false;
		});

		return isValid;
	}

	function clearForm() {
		document.getElementById('formProduto').reset();
		const errorElements = document.querySelectorAll('.invalid-feedback');
		errorElements.forEach(element => element.textContent = '');
		const inputElements = document.querySelectorAll('.is-invalid');
		inputElements.forEach(element => element.classList.remove('is-invalid'));
	}

	document.getElementById('formProduto').addEventListener('submit', function(e) {
		e.preventDefault();

		if (validateForm()) {
			const submitButton = document.getElementById('submitButton');
			const buttonText = document.getElementById('buttonText');
			const buttonSpinner = document.getElementById('buttonSpinner');

			submitButton.disabled = true;
			buttonText.textContent = 'Salvando...';
			buttonSpinner.classList.remove('d-none');

			const formData = new FormData(this);

			fetch('/produtos', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(Object.fromEntries(formData)),
				})
				.then(response => {
					if (!response.ok) {
						return response.json().then(data => {
							throw {
								status: response.status,
								data
							};
						});
					}
					return response.json();
				})
				.then(data => {
					const successModal = new bootstrap.Modal(document.getElementById('successModal'));
					document.getElementById('successMessage').textContent = 'Produto cadastrado com sucesso!';
					successModal.show();

					clearForm();
				})
				.catch(error => {
					if (error.status === 409) {
						// Exibir erro 409 (Conflito) no modal de aviso e no campo do nome
						const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
						const errorMessage = error.data.mensagem || 'Erro ao cadastrar produto.';
						document.getElementById('warningMessage').textContent = errorMessage;
						warningModal.show();

						// Exibir a mesma mensagem no campo do nome
						showError('name', errorMessage);
					} else {
						console.error('Erro:', error);
					}
				})
				.finally(() => {
					submitButton.disabled = false;
					buttonText.textContent = 'Salvar';
					buttonSpinner.classList.add('d-none');
				});
		}
	});
</script>

<?php
require __DIR__ . '/../views/rodape.php';
?>