<?php
/**
 * Funções utilitárias do projeto.
 */

function url(string $path = ''): string
{
    return CONF_URL_BASE . '/' . ltrim($path, '/');
}

function sanitize(string $valor): string
{
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}
