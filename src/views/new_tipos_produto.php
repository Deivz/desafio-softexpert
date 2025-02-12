<?php
require __DIR__ . '/../views/topo.php';
?>

<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0">Cadastrar Novo Tipo de Produto</h5>
        </div>
        <div class="card-body">
          <form id="formTipoProduto" novalidate>
            <div class="mb-3">
              <label for="product_type" class="form-label">Nome do Tipo de Produto*</label>
              <input type="text" class="form-control" id="product_type" name="product_type" required aria-required="true">
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

<script>
  // Funções de validação
  const validations = {
    required: (value) => !value ? "Este campo é obrigatório." : null,
    maxLength: (value) => value.length > 255 ? "Este campo deve possuir no máximo 255 caracteres." : null,
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
      inputElement.classList.add('is-invalid');
    } else {
      errorElement.textContent = '';
      inputElement.classList.remove('is-invalid');
    }
  }

  function validateForm() {
    const fields = [{
      id: 'product_type',
      rules: ['required', 'maxLength']
    }];

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
    document.getElementById('formTipoProduto').reset();
    const errorElements = document.querySelectorAll('.invalid-feedback');
    errorElements.forEach(element => element.textContent = '');
    const inputElements = document.querySelectorAll('.is-invalid');
    inputElements.forEach(element => element.classList.remove('is-invalid'));
  }

  document.getElementById('formTipoProduto').addEventListener('submit', function(e) {
    e.preventDefault();

    if (validateForm()) {
      const submitButton = document.getElementById('submitButton');
      const buttonText = document.getElementById('buttonText');
      const buttonSpinner = document.getElementById('buttonSpinner');

      submitButton.disabled = true;
      buttonText.textContent = 'Salvando...';
      buttonSpinner.classList.remove('d-none');

      const formData = new FormData(this);

      fetch('/tipos_produto', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(Object.fromEntries(formData)),
        })
        .then(response => response.json())
        .then(data => {
          if (data.errors) {
            // Exibir erros do back-end
            Object.entries(data.errors).forEach(([field, errors]) => {
              showError(field, errors.join(' '));
            });
          } else {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            document.getElementById('successMessage').textContent = 'Tipo de produto cadastrado com sucesso!';
            successModal.show();

            clearForm();
          }
        })
        .catch(error => {
          console.error('Erro:', error);
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