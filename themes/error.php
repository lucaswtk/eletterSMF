<?php $v->layout("_theme.php") ?>

<?php
if (empty($_SESSION['login'])):
	$v->start('top-bar-error');
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
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto doloremque sit vero. Enim eum, ipsam.</p>
</div>