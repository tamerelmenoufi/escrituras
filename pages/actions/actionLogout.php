<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === 'logout') {
    session_start();
    session_destroy();
    exit();
}