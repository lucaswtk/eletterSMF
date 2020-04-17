<?php $v->layout("_theme.php") ?>

<?php
if (empty($_SESSION['login'])):
	$v->start('side-bar-error');
	?>
	<nav class="main_nav">
		<a title="Voltar ao início" href="<?= url(); ?>">Voltar</a>
	</nav>
	<?php
	$v->end();
endif;
?>

<div class="error">
	<h2>Ooooops erro <?= $error ?>!</h2>
    <p>Caso o erro persista, entrar em contrato com <a class="emailLink" href="mailto:lucasgabrielpdoliveira@gmail.com">lucasgabrielpdoliveira@gmail.com</a></p>
</div>