<?php
include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #@formatter:off
    $data = $_POST;
    $attr = [];
    $id   = $data["doc_id"];

    unset($data["doc_id"]);

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysqli_real_escape_string($con, $value) . "'";
    }

    $attr = implode(", ", $attr);

    if($id){
        $sql = "UPDATE documentos SET {$attr} WHERE codigo = '{$id}'";
    }else{
       echo json_encode([
           "status"      => true,
           "msg"         => "Error ao salvar",
           "mysql_error" => mysqli_error($con),
       ]);
       exit();
    }



    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "status" => true,
            "msg"    => "Dados salvo com sucesso",
        ]);
    } else {
        echo json_encode([
            "status"      => true,
            "msg"         => "Error ao salvar",
            "query"       => $sql,
            "mysql_error" => mysqli_error($con),
        ]);
    }

    exit();
    #@formatter:on
}

$doc_id = $_GET['doc_id'];

$d = [];

if ($doc_id) {

    $query_vendedor = "SELECT * FROM vendedor_comprador "
        . "WHERE documento_id = '{$doc_id}' AND tipo = 'v' ORDER BY codigo";

    $result_vendedores = mysqli_query($con, $query_vendedor);

    $vendedores = [];

    while ($d_vendedor = mysqli_fetch_object($result_vendedores)) {
        $vendedores[] = $d_vendedor;
    }
}

?>

<form id="form-vendedor" class="needs-validation" novalidate>

    <input type="hidden" id="doc_id" name="doc_id" value="<?= $doc_id ?>">

    <div class="card rounded-0">
        <div class="card-body">
            <div id="vendedor-container">
                <div class="d-flex flex-row justify-content-between mb-2">
                    <h4 class="my-2 text-center">Vendedores</h4>

                    <button
                            type="button"
                            class="btn bg-primary btn-sm text-white adicionar_vendedor"
                            tipo="v"
                    >
                        <i class="fa-solid fa-plus"></i> Adicionar novo
                    </button>

                </div>

                <div class="form-vendedor"></div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <div class="row justify-content-between">
            <div class="col-auto">
                <button
                        voltar
                        type="button"
                        class="btn btn-secondary btn_prev"
                        data-enchanter="previous"
                >
                    Voltar
                </button>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn bg-primary text-white btn_next">Salvar</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function () {

        <?php foreach ($vendedores as $vendedor){?>

        $.ajax({
            url: "./pages/cadastro_documento/_form_vendedor.php",
            data: {
                vendedor_id: '<?= $vendedor->codigo ?>',
                documento_id: '<?= $vendedor->documento_id; ?>',
                tipo: '<?= $vendedor->tipo ?>'
            },
            dataType: "html",
            success: function (data) {
                $(".form-vendedor").append(data);
            }
        });

        <?php } ?>

        var doc_id = window.localStorage.getItem('doc_id');

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/cadastro_documento/documento.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $(".adicionar_vendedor").click(function () {
            let tipo = $(this).attr('tipo');
            let documento_id = $("#doc_id").val();

            $.ajax({
                url: "./pages/editar_documento/_form_vendedor.php",
                data: {
                    documento_id,
                    tipo
                },
                dataType: "html",
                success: function (data) {
                    $(".form-vendedor").append(data);
                }
            })
        });

        $("#form-vendedor").submit(function (e) {
            e.preventDefault();

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            $.ajax({
                url: "./pages/cadastro_documento/vendedor.php",
                type: "post",
                data: formData,
                dataType: "json",
                success: function (data) {

                    $.ajax({
                        url: "./pages/cadastro_documento/comprador.php",
                        type: "get",
                        data: {doc_id},
                        success: function (data) {
                            $(".content-pane").html(data);
                        }
                    });
                }
            });
        });
    });
</script>
