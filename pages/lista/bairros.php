<?php
include '../../config/ConnectionMySQL.php';

$cidade = $_POST['cidade'];

$html = '<option value=""></option>';

if ($cidade) {
    $result = mysqli_query($con, "SELECT * FROM aux_bairros WHERE situacao = '0' AND cidades = '{$cidade}'");

    while ($row = mysqli_fetch_object($result)) {
        $html .= '<option value="' . $row->codigo . '">' . $row->nome . '</option>';
    }
    file_put_contents('debug.txt', $html);
}

echo $html;

die();