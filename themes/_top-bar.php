<?php if (!empty($_SESSION['login'])): ?>
	<nav class="main_nav backImg">
        <div class="navDiv">
		    <img class="navImg" src="<?= url("themes/assets/img/navLogoGrande.png") ?>">
        </div>
		<a title="Início" href="<?= url("home"); ?>"><i class="fa fa-home" style="font-size:16px;"></i> Início</a>
        <a title="Cadastrar carta" href="<?= url("cardCreate"); ?>"><i class="fa fa-align-left" style="font-size:16px;"></i> Cadastrar Carta</a>
        <a title="Cadastrar metadados" href="<?= url("metadataCreate"); ?>"><i class="fa fa-database" style="font-size:16px;"></i> Cadastrar Metadados</a>
        <a title="Cadastrar modelos" href="<?= url("modelCreate"); ?>"><i class="fa fa-modx" style="font-size:16px;"></i> Cadastrar Modelos</a>
		<a title="Encerrar sessão" href="<?= url('logout'); ?>"><i class="fa fa-fw fa-sign-out" style="font-size:16px;"></i> Sair</a>

        <div class="navDate">
            <p>Maceió, <?=utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))) ?></p>
        </div>
	</nav>
<?php endif; ?>
