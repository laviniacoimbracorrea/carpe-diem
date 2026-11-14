<?php

// Detecta automaticamente o nome da pasta em htdocs, inclusive se for renomeada.
// Exemplo: /carpe-diem-etapa07-botao-remover-estilizado/api/index.php
// resulta em http://localhost/carpe-diem-etapa07-botao-remover-estilizado.
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/api/index.php');
$projectPath = rtrim(str_replace('\\', '/', dirname(dirname($scriptPath))), '/');
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if (!preg_match('/^[a-zA-Z0-9.:-]+$/', $host)) $host = 'localhost';
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
define('CONF_URL_BASE', $scheme . '://' . $host . ($projectPath === '.' || $projectPath === '/' ? '' : $projectPath));
define('CONF_URL_TEST', CONF_URL_BASE);

const CONF_DB_HOST = "localhost";
const CONF_DB_NAME = "projeto";
const CONF_DB_USER = "root";
const CONF_DB_PORT = "3306";
const CONF_DB_PASS = "";

const JWT_SECRET_KEY = "e17851db9fee8e49f728550fc2f82111c4374f426c9cadda9403390ef638073ff21fd7a7e35d025861e175b0fb93609d838fba3185c859c13b9f43cf92ecbd48";