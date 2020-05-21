<?php $v->layout("_theme.php") ?>

<div class="loginDiv">
    <div class="loginLeftSide">
        <img class="loginImg" title="Créditos: br.freepik.com" src="<?= url("/themes/assets/img/person-2.png") ?>">
        <h3 class="loginH3">Bem vindo ao Eletter!</h3>
        <p>Caso já possua uma conta, clique no botão abaixo e acesse</p>

        <div class="loginLeftSideButton">
            <div>
                <a class="btnLoginLeft" href="<?= $router->route('web.login'); ?>">Voltar</a>
            </div>
        </div>
    </div>
    <div class="createRightSide">
        <h3>Cadastrar conta</h3>
        <form class="loginForm" id="form" action="<?= $router->route('web.validateAccount'); ?>" method="POST">
            <div>
                <i class="loginFa fa fa-user"></i>
                <input class="loginInput" type="text" name="name" placeholder="Insira seu nome" required>
            </div>
            <div>
                <i class="loginFa fa fa-th"></i>
                <input class="loginInput" type="text" name="registration" placeholder="Insira seu número de matrícula" required>
            </div>
            <div>
                <i class="loginFa fa fa-envelope"></i>
                <input class="loginInput" type="email" name="email" placeholder="Insira seu email" required>
            </div>
            <div>
                <i class="loginFa fa fa-lock"></i>
                <input class="loginInput" type="password" name="password" placeholder="Insira sua senha" required>
            </div>
            <div>
                <i class="loginFa fa fa-building"></i>
                <select class="loginInput" name="organ" required>
                    <option value="0" class="opt0" selected>Selecione o órgão</option>
                    <option value="1">Semec</option>
                    <option value="2">Semge</option>
                </select>
            </div>
            <button class="btnLogin" type="submit" onclick="submitForm()">Cadastrar</button>
        </form>
    </div>
</div>
