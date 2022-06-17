<?php
#include '../config/includes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === "excluir") {
    include_once "../config/ConnectionMySQL.php";

    $codigo = $_POST["codigo"];

    if (mysqli_query($con, "DELETE FROM documentos WHERE codigo = '{$codigo}'")) {
        echo json_encode([
            "status" => true,
            "msg" => "Registro excluído com sucesso"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "msg" => "Error ao excluir"
        ]);
    }
    exit();
}

$colunas_array = [
    "d.codigo",
    "d.situacao",
    "vendedor_nome",
    "comprador_nome",
    "m.nome AS end_municipio",
    "b.nome AS end_bairro",
];

$colunas = implode(", ", $colunas_array);

$query = "SELECT {$colunas} FROM documentos d "
    . "LEFT JOIN aux_cidades m ON m.codigo = d.cidade "
    . "LEFT JOIN aux_bairros b ON b.codigo = d.bairro ";

$result = mysqli_query($con, $query);

?>

<div class="container py-5">
    <h2 class="text-center">Lista de cadastros</h2>

    <div style="margin-bottom: 6rem">
        <table class="table my-5">
            <thead>
            <tr>
                <th class="color-gray" scope="col">Vendedor</th>
                <th class="color-gray" scope="col">Comprador</th>
                <th class="color-gray" scope="col">Município</th>
                <th class="color-gray" scope="col">Bairro</th>
                <th class="color-gray" scope="col">Situação</th>
                <th class="color-gray" scope="col" style="width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($d = mysqli_fetch_object($result)): ?>
                <tr id="documento-<?= $d->codigo; ?>">
                    <td><?= $d->vendedor_nome ?: 'Não definido' ?></td>
                    <td><?= $d->comprador_nome ?: 'Não definido' ?></td>
                    <td><?= $d->end_municipio ?: 'Não definido' ?></td>
                    <td><?= $d->end_bairro ?: 'Não definido' ?></td>
                    <td><?= $d->situacao; ?></td>
                    <td class="text-center">
                        <a href="./editar-documento?id=<?= $d->codigo ?>" type="button" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button
                                type="button"
                                class="btn btn-light btn-sm excluir-documento"
                                data-codigo="<?= $d->codigo; ?>"
                        >
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        $(".excluir-documento").click(function () {
            var codigo = $(this).data("codigo");

            $.alert({
                title: "Aviso",
                content: "Tem certeza que deseja excluir?",
                buttons: {
                    sim: {
                        text: 'sim',
                        action: function () {
                            $.ajax({
                                url: "./pages/lista-cadastros.php",
                                method: "post",
                                data: {codigo, acao: "excluir"},
                                dataType: "json",
                                success: function (response) {
                                    if (response.status) {
                                        $.alert({
                                            title: 'Sucesso',
                                            content: response.msg
                                        });

                                        $(`#documento-${codigo}`).remove();
                                    } else {
                                        $.alert({
                                            title: 'Error',
                                            content: response.msg
                                        });
                                    }
                                }
                            })
                        }
                    },
                    nao: {
                        text: 'Não',
                        action: () => {
                        },
                    }
                }
            })
        })
    });
</script>
