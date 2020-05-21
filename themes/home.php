<?php $v->layout("_theme.php") ?>

<?php $v->start("home-content"); ?>
<div class="homeDiv">
    <img class="imgHome" src="<?= url("/themes/assets/img/person.png") ?>">
    <p class="pHome">Olá <?= $name; ?>! É bom te ter por aqui</p>
    <span class="spanHome"><?= SITE ?> Todos os direitos reservados</span>
</div>
<?php $v->end(); ?>

<?php $v->start("scripts"); ?>
    <script>
        <?php
            if(isset($_SESSION['login']['lotSend']) && $_SESSION['login']['lotSend'] == 1):
                unset($_SESSION['login']['lotSend']);
        ?>
                alert("Lote enviado com sucesso");
        <?php
            elseif(isset($_SESSION['login']['lotSend']) && $_SESSION['login']['lotSend'] == 2):
                unset($_SESSION['login']['lotSend']);
        ?>
            alert("Não há lotes para serem enviados");
        <?php
            endif;
        ?>
    </script>
<?php $v->end(); ?>
