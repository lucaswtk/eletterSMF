<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Dados do Destinatário</h3>
    <label class="labelCard">Nome
        <input class="myInput" type="text" name="receiverName" title="Nome do destinatário" placeholder="Nome completo do destinatário">
    </label>

    <label class="labelCardLeft">Endereço
        <input class="myInput" type="text" name="receiverAddress" title="Endereço do destinatário" placeholder="Endereço do destinatário">
    </label>

    <label class="labelCardRight">Número da residência
        <input class="myInput" type="number" name="receiverCity" title="Número da residência" placeholder="Número da residência do destinatário">
    </label>

    <label class="labelCardLeft">CEP
        <input class="myInput" type="number" title="CEP do destinatário" placeholder="00000-000">
    </label>

    <label class="labelCardRight">Cidade
        <input class="myInput" type="text" title="Cidade do destinatário" placeholder="Cidade do destinatário">
    </label>

    <label class="labelCardLeft">Bairro
        <input class="myInput" type="text" title="Bairro do destinatário" placeholder="Bairro do destinatário">
    </label>

    <label class="labelCardRight">Complemento
        <input class="myInput" type="text" title="Complemento não obrigatório" placeholder="Deixar em branco caso não haja">
    </label>

    <label class="labelCardLeft">Estado
        <select class="myInput" title="Estado do destinatário">
            <option class="opt0" value="0">Selecione o estado</option>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>]
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espirito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Matro Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
    </label class="labelCard">

    <label class="labelCardRight">Modelo de documento
        <select id="modelValue" class="myInput" title="Modelo do documento">
            <option class="opt0">Selecione o modelo</option>
            <?php foreach ($models as $model): ?>
                <option value="<?= $model->id ?>"><?= $model->name ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <div id="inputSide"></div>

    <div class="btnDiv">
        <button class="btnCard">Cadastrar</button>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
    $("#modelValue").change(function(){
        let value = $("#modelValue option:selected").val();
        let inputs = "";
        $.post("<?= $router->route("web.fieldsFilter"); ?>", value, function (e) {
            let values = e.split("$");
            values.splice(0, 1);

            values.forEach(function (fieldValue) {
                fieldValue = fieldValue.split("-");
                inputs = '<label class="labelCard">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'"></label>' + inputs;
            })

            document.getElementById("inputSide").innerHTML = inputs;
        }, "html").fail(function () {
            alert("Erro ao processar requisição!");
        });
    });
</script>
<?php $v->end(); ?>
