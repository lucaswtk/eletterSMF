<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?= $title; ?></title>
		<link rel="shortcut icon" href="<?= url("themes/assets/img/favicon.png"); ?>" type="image/x-icon">
		<link rel="stylesheet" href="<?= url("themes/assets/css/style.css"); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<?= $v->section('top-bar-error'); ?>
		<?php $v->insert('_top-bar'); ?>

        <?php if (!empty($_SESSION['login'])): ?>
            <main class="main_content">
                <?= $v->section("content"); ?>
            </main>
        <?php else: ?>
            <main class="login_content">
                <?= $v->section("content"); ?>
            </main>
        <?php endif; ?>

<!--		<footer class="main_footer">-->
<!--			--><?//= SITE; ?><!-- - Todos os Direitos Reservados-->
<!--		</footer>-->

		<script src="<?= url('themes/assets/js/jquery.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<?= $v->section("scripts") ?>
	</body>
</html>
