<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require __DIR__ . "/api/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);


if ($parts[2] = "api" && $parts[3] != "beverages") {
    http_response_code(404);
    exit;
}



$id = $parts[4] ?? null;

$database = new Database("localhost", "rest_project", "root", "");

$gateway = new BeveragesGateway($database);

$controller = new BeveragesController($gateway);

$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);


?>












