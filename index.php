<?php

require_once "vendor/autoload.php";

$data = [
    'name' => [
        "arash",
        "narimani" => ['test' => 12],
    ]
];

wc($data, 12);