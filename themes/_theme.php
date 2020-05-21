<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?= $title; ?></title>
		<link rel="shortcut icon" href="<?= url("themes/assets/img/favicon.png"); ?>" type="image/x-icon">
		<link rel="stylesheet" href="<?= url("themes/assets/css/large-1.css"); ?>" media="screen and (min-width: 1350px)">
        <link rel="stylesheet" href="<?= url("themes/assets/css/small.css"); ?>" media="screen and (max-width: 1349px)">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<?= $v->section('side-bar-error'); ?>
		<?php $v->insert('_side-bar'); ?>

        <?php if (!empty($_SESSION['login']) && empty($v->section("home-content"))): ?>
            <main class="main_content">
                <?= $v->section("content"); ?>
            </main>
        <?php  elseif(!empty($_SESSION['login']) && !empty($v->section("home-content"))): ?>
            <main class="home_content">
                <?= $v->section("home-content"); ?>
            </main>
        <?php else: ?>
            <main class="login_content"></main>
                <?= $v->section("content"); ?>
            </main>
        <?php endif; ?>

		<script src="<?= url('themes/assets/js/jquery.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<?= $v->section("scripts") ?>
        <script>
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
	</body>
</html>
