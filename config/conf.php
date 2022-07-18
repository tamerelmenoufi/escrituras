<?php

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] != 'localhost' ? 'escrituras.mohatron.com/' : 'localhost/escrituras';
$base_url = $protocol . "://" . $host . '/';

if (session_id() === "") {
    session_start();
}

date_default_timezone_set('America/Manaus');
header('Content-Type: text/html; charset=utf-8');

$random = random_string();

function random_string()
{
    $int = rand(0, 51);
    $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $rand_letter = $a_z[$int];
    $c = uniqid($rand_letter);
    $c = substr($c, 0, 5);
    return $c;
}