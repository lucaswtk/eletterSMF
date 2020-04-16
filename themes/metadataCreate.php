<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Cadastro de metadados</h3>

    <form id="form" action="<?= $router->route('web.validateMetadata'); ?>" method="POST">
        <label class="labelCardLeft">Nome do metadado
            <input id="metadataName" class="myInput" type="text" title="Nome do metadado" name="metadataName" placeholder="Ex: nomeCadastrante" required>
        </label>

        <label class="labelCardRight">Nome do label
            <input id="metadataLabel" class="myInput" type="text" title="Nome que aparecerá em cima do campo ao cadastrar cartas" name="metadataLabelName" placeholder="Ex: Nome cadastrante" required>
        </label>

        <label class="labelCardLeft">Descrição
            <input id="metadataDecription" class="myInput" type="text" title="Descrição do metadado" name="metadataDescription" placeholder="Ex: Nome dado do usuário cadastrante" required>
        </label>

        <label class="labelCardRight">Tipo
            <select id="metadataType" class="myInput" name="metadataType" required>
                <option class="opt0" value="0">Selecione o tipo do metadado</option>
                <option value="Text">Text</option>
                <option value="Number">Number</option>
                <option value="Email">Email</option>
                <option value="Date">Date</option>
                <option value="Tel">Tel</option>
                <option value="Time">Time</option>
            </select>
        </label>

        <div class="btnDiv">
            <button id="btnSend" class="btnCard" type="button">Cadastrar</button>
        </div>
    </form>
</div>

<?php $v->start("scripts"); ?>
    <script>
        <?php
            if(isset($_SESSION['login']['cratedMetadata'])):
                unset($_SESSION['login']['cratedMetadata']);
        ?>
                alert("Metadado cadastrado com sucesso");
        <?php
            endif;
        ?>

        $('#btnSend').click(function (){
            if($('#metadataName').val() === ''){
                alert('Insira o nome do metadado');
            }else{
                if($('#metadataLabel').val() === ''){
                    alert('Insira o label/rótulo do metadado');
                }else{
                    if($('#metadataDecription').val() === ''){
                        alert('Insira a descrição do metadado');
                    }else{
                        if($('#metadataType').val() == 0){
                            alert('Selecione o tipo do metadado');
                        }else{
                            $('#form').submit();
                        }
                    }
                }
            }
        });
    </script>
<?php $v->end(); ?>
