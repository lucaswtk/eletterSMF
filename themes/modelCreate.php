<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Cadastro de modelo</h3>
    <form id="form" action="<?= $router->route('web.validateModel'); ?>" method="POST">
        <label class="labelCardLeft">Nome do modelo
            <input class="myInput" type="text" name="modelName" placeholder="Nome que aparecerá no cadastro de cartas" required>
        </label>
        <label class="labelCardRight">Imagens
            <input class="myInput" name="modelImages" type="file" required>
        </label>

        <label class="labelCardLeft">Código html</label>
        <textarea class="myTextarea modelTextarea" rows="15" name="modelCode" placeholder="Insira o html do modelo com os metadados em seus respectivos locais" required></textarea>

        <div class="myTextarea modelDiv">
            <p  class="labelCard">Metadados cadastrados</p>
            <?php
            if(!empty($metadata)):
                foreach ($metadata as $data): ?>
                    <p class="pTitle" title="<?= $data->description ?>"> $<?= $data->name ?></p>
                <?php
                endforeach;
            endif;
            ?>
        </div>

        <div class="btnDiv">
            <button class="btnCard">Cadastrar</button>
        </div>
    </form>
</div>