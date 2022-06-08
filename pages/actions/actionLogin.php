<?php
include '../../config/includes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === 'login') {
    header('Content-Type: text/html; charset=utf-8');
    $usuario = mysqli_escape_string($con, $_POST['nome']);
    $senha = md5($_POST['senha']);

    $query = "SELECT codigo FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result)) {
        $d = mysqli_fetch_object($result);

        $_SESSION['usuario'] = [
            'codigo' => $d->codigo,
        ];

        echo json_encode([
            "status" => true,
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "msg" => "Usuário não encontrado",
        ]);
    }
    exit();
}