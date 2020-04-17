<?php $v->layout("_theme.php") ?>

<div class="content">
    <h3>Dados do Destinatário</h3>
    <form method="POST" action="<?= $router->route('web.validateCard'); ?>">
        <div id="firstPage">
            <label class="labelCard">Nome
                <input id="receiverName" class="myInput" type="text" name="receiverName" title="Nome do destinatário" placeholder="Nome completo do destinatário">
            </label>

            <label class="labelCardLeft">Rua
                <input id="receiverStreet" class="myInput" type="text" name="receiverStreet" title="Rua do destinatário" placeholder="Endereço do destinatário">
            </label>

            <label class="labelCardRight">Número da residência
                <input id="receiverNumberAddress" class="myInput" type="number" name="receiverNumberAddress" title="Número da residência" placeholder="Número da residência do destinatário">
            </label>

            <label class="labelCardLeft">CEP
                <input id="receiverPostcode" class="myInput" type="number" name="receiverPostcode" title="CEP do destinatário" placeholder="00000-000">
            </label>

            <label class="labelCardRight">Cidade
                <input id="receiverCity" class="myInput" type="text" name="receiverCity" title="Cidade do destinatário" placeholder="Cidade do destinatário">
            </label>

            <label class="labelCardLeft">Bairro
                <input id="receiverNeighborhood" class="myInput" type="text" name="receiverNeighborhood" title="Bairro do destinatário" placeholder="Bairro do destinatário">
            </label>

            <label class="labelCardRight">Complemento
                <input id="receiverComplement" class="myInput" type="text" name="receiverComplement" title="Complemento não obrigatório" placeholder="Deixar em branco caso não tenha">
            </label>

            <label class="labelCardLeft">Estado
                <select id="receiverState" class="myInput" title="Estado do destinatário" name="receiverState">
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
            <div class="btnDiv">
                <button class="btnCard" type="button" onclick="nextPage()">
                    Avançar
                </button>
            </div>
        </div>

        <div id="secondPage" class="secondPage"></div>
    </form>
</div>

<?php $v->start("scripts"); ?>
    <script>
        <?php
            if(isset($_SESSION['login']['cratedCards'])):
                unset($_SESSION['login']['cratedCards']);
        ?>
                alert("Carta cadastrada com sucesso");
        <?php
            endif;
        ?>

        $('#secondPage').hide();

        $("#modelValue").change(function(){
            let value = $("#modelValue option:selected").val();
            let inputs = "";
            $.post("<?= $router->route("web.fieldsFilter"); ?>", value, function (e) {
                let values = e.split("$");
                let aux  = values.length;
                let count = 0;
                let modelId;
                values.splice(0, 1);
                values.forEach(function (fieldValue) {
                    fieldValue = fieldValue.split("-");
                    modelId = fieldValue[5];
                    if(count % 2 === 0){
                        if (count === (aux-2)){
                            if(fieldValue[4] == 1){
                                inputs = inputs + '<label class="labelCard">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'" required></label> <div class="btnDiv"><button class="btnCard btnSecond btnSecondLeft" type="button" onclick="lastPage()">Voltar</button><button class="btnCard btnSecondRight">Cadastrar</button></div>';
                            }else{
                                inputs = inputs + '<label class="labelCard">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'"></label> <div class="btnDiv"><button class="btnCard btnSecond btnSecondLeft" type="button" onclick="lastPage()">Voltar</button><button class="btnCard btnSecondRight">Cadastrar</button></div>';
                            }
                        }else{
                            if(fieldValue[4] == 1){
                                inputs = inputs + '<label class="labelCardLeft">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'" required></label>';
                            }else{
                                inputs = inputs + '<label class="labelCardLeft">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'"></label>';
                            }
                        }
                    }else{
                        if(fieldValue[4] == 1){
                            inputs = inputs + '<label class="labelCardRight">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'" required></label>';
                        }else{
                            inputs = inputs + '<label class="labelCardRight">'+ fieldValue[1] +'<input class="myInput" name="'+ fieldValue[0] +'" type="'+ fieldValue[3] +'" title="'+ fieldValue[2] +'" placeholder="'+ fieldValue[2] +'"></label>';
                        }
                    }
                    count++;
                });
                inputs = inputs + '<input type="hidden" name="modelId" value="'+ modelId +'">';
                document.getElementById("secondPage").innerHTML = inputs;
            }, "html").fail(function () {
                alert("Erro ao processar requisição!");
            });
        });

        function nextPage() {
            if($('#receiverName').val() === ""){
                alert("Insira um nome");
            }else{
                if($('#receiverStreet').val() === ""){
                    alert("Insira a rua");
                }else{
                    if($('#receiverNumberAddress').val() === ""){
                        alert("Insira o número da residência");
                    }else{
                        if($('#receiverPostcode').val() === ""){
                            alert("Insira o CEP");
                        }else{
                            if($('#receiverCity').val() === ""){
                                alert("Insira a cidade");
                            }else{
                                if($('#receiverNeighborhood').val() === ""){
                                    alert("Insira o bairro");
                                }else{
                                    if($('#receiverState').val() == 0){
                                        alert("Selecione o estado");
                                    }else{
                                        let divLength = $('#secondPage').html().length;
                                        if(divLength === 0){
                                            alert("Selecione um modelo de documento.");
                                        }else{
                                            $('#firstPage').animate({opacity: 0}, 'fast', function(){
                                                $('#firstPage').hide();
                                                $('#secondPage').animate({opacity: 1}, 'fast', function(){
                                                    $('#secondPage').show();
                                                });
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function lastPage(){
            $('#secondPage').animate({opacity: 0}, 'fast', function(){
                $('#secondPage').hide();
                $('#firstPage').animate({opacity: 1}, 'fast', function(){
                    $('#firstPage').show();
                });
            });
        }
    </script>
<?php $v->end(); ?>
