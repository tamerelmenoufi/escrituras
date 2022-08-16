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

$doc_id = $_SESSION['id'];

$d = [];

if ($doc_id) {
    $query_comprador = "SELECT * FROM vendedor_comprador "
        . "WHERE documento_id = '{$doc_id}' AND tipo = 'c' ORDER BY codigo";

    $result_compradores = mysqli_query($con, $query_comprador);

    $compradores = [];

    while ($d_comprador = mysqli_fetch_object($result_compradores)) {
        $compradores[] = $d_comprador;
    }
}
?>

<form id="form-comprador" class="needs-validation" novalidate>

    <input type="hidden" id="doc_id" name="doc_id" value="<?= $doc_id ?>">

    <div class="card rounded-0">
        <div class="card-body">
            <div class="comprador-container">
                <div class="d-flex flex-row justify-content-between mb-2">
                    <h4 class="my-2 text-center">Comprador</h4>

                    <button
                            type="button"
                            class="btn bg-primary btn-sm text-white adicionar_comprador"
                            tipo="c"
                    >
                        <i class="fa-solid fa-plus"></i> Adicionar novo
                    </button>

                </div>

                <div class="form-comprador"></div>
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
                <button type="submit" class="btn bg-primary btn_next">Salvar</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function () {

        <?php foreach ($compradores as $comprador){?>

        $.ajax({
            url: "./pages/documentos/_form_comprador.php",
            data: {
                comprador_id: '<?= $comprador->codigo ?>',
                documento_id: '<?= $comprador->documento_id; ?>',
                tipo: '<?= $comprador->tipo ?>'
            },
            dataType: "html",
            success: function (data) {
                $(".form-comprador").append(data);
            }
        });

        <?php } ?>

        var doc_id = $("#doc_id").val();

        $(".adicionar_comprador").click(function () {
            let tipo = $(this).attr('tipo');
            let documento_id = $("#doc_id").val();

            $.ajax({
                url: "./pages/documentos/_form_comprador.php",
                data: {
                    documento_id,
                    tipo,
                    acao:'novo'
                },
                dataType: "html",
                success: function (data) {
                    $(".form-comprador").load("./pages/documentos/_form_comprador.php?comprador_id="+data);
                    // $(".form-comprador").append(data);
                }
            })
        });

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/documentos/vendedor.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $("#form-comprador").submit(function (e) {
            e.preventDefault();

            //if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            $.ajax({
                url: "./pages/documentos/comprador.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);

                    $.ajax({
                        url: "./pages/documentos/endereco.php",
                        type: "GET",
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