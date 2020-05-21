<?php $v->layout("_theme.php") ?>

<?php $v->start("scripts") ?>
<script>
	function submitForm() {
		if ($("#registration").val() === "" || $("#password").val() === "" || $("#organ option:selected").val() == 0) {
			alert("Preencha todos os campos");
		} else {
			$("#form").submit();
		}
	}
</script>
<?php $v->end() ?>

<div class="loginDiv">
    <div class="loginLeftSide">
        <img class="loginImg" title="Créditos: br.freepik.com" src="<?= url("/themes/assets/img/person.png") ?>">
        <h3 class="loginH3">Bem vindo ao Eletter!</h3>
        <p>Caso seja novo por aqui, clique no botão abaixo e cadastre-se</p>

        <div class="loginLeftSideButton">
            <div>
                <a class="btnLoginLeft" href="<?= $router->route('web.accountCreate'); ?>">Cadastrar</a>
            </div>
        </div>
    </div>
    <div class="loginRightSide">
        <h3>Acesse sua conta</h3>
        <form class="loginForm" id="form" action="<?= $router->route('web.validateLogin'); ?>" method="POST">
            <div>
                <i class="loginFa fa fa-th"></i>
                <input id="registration" class="inputNumber loginInput" type="number" min="0" name="registration" placeholder="Insira sua matrícula">
            </div>
            <div>
                <i class="loginFa fa fa-lock"></i>
                <input id="password" class="loginInput" type="password" name="password" placeholder="Insira sua senha">
            </div>
            <div>
                <i class="loginFa fa fa-building"></i>
                <select id="organ" class="loginInput" name="organ">
                    <option value="0" class="opt0" selected>Selecione o órgão</option>
                    <option value="1">Semec</option>
                    <option value="2">Semge</option>
                </select>
            </div>
            <button class="btnLogin" type="button" onclick="submitForm()">Entrar</button>
        </form>
    </div>
</div>