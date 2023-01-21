<?php

$options = [
    "http" => [
        "method" => "GET",
        "header" => "Content-type: application/json; charset=UTF-8\r\n" .
                    "Accept-language: en",
    ]
];

$context = stream_context_create($options);

$data = file_get_contents("http://localhost/projectREST/back/api/beverages/1", false, $context);

$response = json_decode($data, true);
var_dump($response);