<?php
include '../../config/ConnectionMySQL.php';

$estado = $_POST['estado'];

$html = '<option value=""></option>';

if ($estado) {
    $result = mysqli_query($con, "SELECT * FROM aux_cidades WHERE situacao = '0' AND estados = '{$estado}'");

    while ($row = mysqli_fetch_object($result)) {
        $html .= '<option value="' . $row->codigo . '">' . $row->nome . '</option>';
    }
}

echo $html;
die();