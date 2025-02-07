<?php
require 'topo.php';

if (isset($_SESSION['dadosUsuario'])) {
	extract($_SESSION['dadosUsuario']);
}

if (isset($_SESSION['mensagens'])):
	foreach ($_SESSION['mensagens'] as $mensagem) :
?>
		<div class="container mt-3 alert alert-danger">
			<?= $mensagem ?>
		</div>

<?php
	endforeach;
endif;
?>

<main>
	<form class="mt-3 container" action="cadastro" method="post">
		<div class="mb-3">
			<label for="nome" class="form-label">Nome*</label>
			<input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do produto" maxlength="100" value="<?= $nome ?>">
		</div>
		<div class="mb-3">
			<label for="cpf" class="form-label">Preço*</label>
			<input name="cpf" type="text" class="form-control" id="cpf" placeholder="CPF somente números" maxlength="14" value="<?= $cpf ?>">
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Tipo*</label>
			<input name="email" type="email" class="form-control" id="email" placeholder="nome@exemplo.com" maxlength="50" value="<?= $email ?>">
		</div>
		<button type="submit" id="submit" class="btn btn-primary">Cadastrar</button>

	</form>
</main>

<?php
unset($_SESSION['dadosUsuario']);
unset($_SESSION['mensagens']);
unset($_SESSION['erros']);
?>

<?php
require 'rodape.php';
?>