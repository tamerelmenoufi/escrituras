<?php
include '../../config/ConnectionMySQL.php';

$cidade = $_POST['valor'];

$html = '<option value=""></option>';

if ($cidade) {
    $result = mysqli_query($con, "SELECT * FROM aux_bairros WHERE situacao = '1' AND cidades = '{$cidade}'");

    while ($row = mysqli_fetch_object($result)) {
        $html .= '<option value="' . $row->codigo . '">' . $row->nome . '</option>';
    }
}

echo $html;

die();
