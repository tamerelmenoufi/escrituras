<?php
header('Content-Type: application/json'); // set json response headers
$dados = $_POST;
unlink("../../" . $_POST['path']);
echo json_encode($_POST);
die;