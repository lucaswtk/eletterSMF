<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Cadastro de modelo</h3>
    <form id="form" action="<?= $router->route('web.validateModel'); ?>" method="POST" enctype="multipart/form-data">
        <label class="labelCardLeft">Nome do modelo
            <input class="myInput" type="text" name="modelName" placeholder="Nome que aparecerá no cadastro de cartas" required>
        </label>
        <label class="labelCardRight">Imagens
            <input id="modelImages" class="myInput" name="modelImages[]" type="file" accept="image/png, image/jpg, image/jpeg" required multiple>
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
            <button id="btnSubmit" type="submit" class="btnCard">Cadastrar</button>
        </div>
    </form>
</div>

<?php $v->start("scripts") ?>
    <script>
        <?php
            if(isset($_SESSION['login']['cratedModel'])):
                unset($_SESSION['login']['cratedModel']);
        ?>
                alert("Modelo cadastrado com sucesso");
        <?php
            endif;
        ?>

        $(document).ready(function(){
            $('#modelImages').change(function(e){
                let count = e.target.files.length;
                let i;
                for (i = 0; i < count; i++){
                    var fileName = e.target.files[i].name;
                    var ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                    if(!(ext === 'jpg' || ext === 'jpeg' || ext === 'png')){
                        alert("O tipo do anexo é inválido. Por favor, insira imagens em formato JPEG, JPG ou PNG.");
                        $('#modelImages').val('');
                    }
                    if(e.target.files[i].size > 1133695){
                        alert("Por favor, insira imagens de no máximo 1mb cada.");
                        $('#modelImages').val('');
                    }
                }
            });
        });
    </script>
<?php $v->end() ?>
