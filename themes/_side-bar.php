<?php if (!empty($_SESSION['login'])): ?>
	<nav class="main_nav backImg">
        <a title="Início" href="<?= url("home"); ?>"><i class="fa fa-home faNav" style="font-size:16px;"></i> <span>Início</span></a>
        <a title="Gráficos" href="<?= url("dashboard"); ?>"><i class="fa fa-dashboard faNav" style="font-size:16px;"></i> <span>Geral</span></a>
<!--        <a title="Cadastrar carta" href="--><?//= url("cardCreate"); ?><!--"><i class="fa fa-align-left faNav" style="font-size:16px;"></i> <span>Carta</span></a>-->
        <a class="metadataCrete" title="Cadastrar metadados" href="<?= url("metadataCreate"); ?>"><i class="fa fa-database faNav" style="font-size:16px;"></i>Metadados</a>
        <a class="modelCreate" title="Cadastrar modelos" href="<?= url("modelCreate"); ?>"><i class="fa fa-modx faNav" style="font-size:16px;"></i>Modelos</a>
        <div class="dropdown" title="Cadastrar carta">
            <a onclick="myFunction()" class="dropbtn">Cartas</a>
            <div id="myDropdown" class="dropdown-content">
                <a class="dropItem" href="<?= url("cardCreate"); ?>">Cadastrar carta</a>
                <a class="dropItem" href="<?= url("cardList"); ?>">Listar cartas</a>
            </div>
        </div>
        <a class="lotSend" title="Enviar lote" href="<?= url("lotSend"); ?>"><i class="fa fa-share faNav" style="font-size:16px;"></i> Enviar Lote</a>
        <a class="exit" title="Encerrar sessão" href="<?= url('logout'); ?>"><i class="fa fa-fw fa-sign-out faNav" style="font-size:16px;"></i> <span>Sair</span></a>
	</nav>
<?php endif; ?>
