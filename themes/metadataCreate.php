<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Cadastro de metadados</h3>

    <form id="form" action="<?= $router->route('web.validateMetadata'); ?>" method="POST">
        <label class="labelCardLeft">Nome do metadado
            <input class="myInput" type="text" title="Nome do metadado" name="metadataName" placeholder="Ex: nomeCadastrante" required>
        </label>

        <label class="labelCardRight">Nome do label
            <input class="myInput" type="text" title="Nome que aparecerá em cima do campo ao cadastrar cartas" name="metadataLabelName" placeholder="Ex: Nome cadastrante" required>
        </label>

        <label class="labelCardLeft">Descrição
            <input class="myInput" type="text" title="Descrição do metadado" name="metadataDescription" placeholder="Ex: Nome dado do usuário cadastrante" required>
        </label>

        <label class="labelCardRight">Tipo
            <select class="myInput" name="metadataType" required>
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
            <button class="btnCard">Cadastrar</button>
        </div>
    </form>
</div>