<?php
// Conversor para pdf https://pdf.io/pt/doc2pdf/
// Remover pagina do pdf https://www.ilovepdf.com/pt/excluir-paginas-do-pdf
// Conversor para html https://www.pdftohtml.net/
session_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(ROOT);

/*
 * Contorllers
 */

$router->namespace("Source\App");

/*
 * Web
 */
$router->group(null);
$router->get("/", "Web:login", 'web.login');
$router->get('/logout', 'Web:logout', 'web.logout');
$router->post("/login", "Web:validateLogin", 'web.validateLogin');
$router->get("/accountCreate", "Web:accountCreate", 'web.accountCreate');
$router->post("/validateAccount", "Web:validateAccount", 'web.validateAccount');

$router->get("/home", "Web:home", 'web.home');
$router->get("/dashboard", "Web:dashboard", 'web.dashboard');
$router->post("/confirmAccount", "Web:confirmAccount", "web.confirmAccount");
$router->post("/removeAccount", "Web:removeAccount", "web.removeAccount");

$router->get("/cardList", "Web:cardList", "web.cardList");
$router->get("/cardList/{file}", "Web:openFile", "web.openFile");
$router->post("/cardShare", "Web:cardShare", "web.cardShare");
$router->get("/cardCreate", "Web:cardCreate", "web.cardCreate");
$router->post("/validateCard", "Web:validateCard", "web.validateCard");
$router->post("/fieldsFilter", "Web:fieldsFilter", "web.fieldsFilter");

$router->get("/metadataCreate", "Web:metadataCreate", "web.metadataCreate");
$router->post("/validateMetadata", "Web:validateMetadata", "web.validateMetadata");
$router->get("/modelCreate", "Web:modelCreate", "web.modelCreate");
$router->post("/validateModel", "Web:validateModel", "web.validateModel");
$router->get("/lotSend", "Web:lotSend", "web.lotSend");

/*
 * ERROS
 */
$router->group("ooops");
$router->get("/{errcode}", "Web:error");

/**
 * PROCESS
 */
$router->dispatch();

if ($router->error()) {
	$router->redirect("/ooops/{$router->error()}");
}