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

<div class="loginForm">
	<form id="form" action="<?= $router->route('web.validateLogin'); ?>" method="POST">
        <div class="loginDiv">
		    <img class="loginImg" src="<?= url("/themes/assets/img/logo.png") ?>">
        </div>

        <label class="labelLogin">Matrícula
            <input id="registration" class="myInput inputNumber inputLogin" type="number" min="0" name="registration" placeholder="Insira sua matrícula">
        </label>

        <label class="labelLogin">Senha
            <input id="password" class="myInput inputLogin" type="password" name="password" placeholder="Insira sua senha">
        </label>

        <label class="labelLogin">Órgão
            <select id="organ" class="myInput inputLogin" name="organ">
                <option value="0" class="opt0" selected>Selecione o órgão</option>
                <option value="1">Semec</option>
                <option value="2">Semge</option>
            </select>
        </label>

<!--        <label>-->
<!--			<input id="registration" class="loginInput inputNumber" type="number" min="0" name="registration" placeholder="Matrícula">-->
<!--		</label>-->
<!--		<label>-->
<!--			<input id="password" class="loginInput" type="password" name="password" placeholder="Senha">-->
<!--		</label>-->
<!--		<label>-->
<!--			<select id="organ" class="loginInput" name="organ">-->
<!--				<option value="0" class="opt0" selected>Selecione o órgão</option>-->
<!--				<option value="1">Semec</option>-->
<!--				<option value="2">Semge</option>-->
<!--			</select>-->
<!--		</label>-->
		<button class="btnLogin" type="button" onclick="submitForm()">Entrar</button>
	</form>
</div>