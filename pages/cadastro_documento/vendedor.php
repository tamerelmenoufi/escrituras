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
    $result = mysqli_query($con, "SELECT * FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);

    $query_vendedor = "SELECT * FROM vendedores "
        . "WHERE documento_id = '{$d->codigo}' ORDER BY tipo_vendedor";
    $result_vendedores = mysqli_query($con, $query_vendedor);

    $vendedores = [];
    $vendedores_procurador = [];

    while ($d_vendedor = mysqli_fetch_object($result_vendedores)) {

        if ($d_vendedor->tipo_vendedor == 'v') {
            $vendedores[] = $d_vendedor;
        } elseif ($d_vendedor->tipo_vendedor == 'p') {
            $vendedores_procurador[] = $d_vendedor;
        }

    }
}
?>
<form id="form-vendedor" class="needs-validation" novalidate>

    <div id="vendedor-container">
        <h4 class="my-2 text-center">Vendedor</h4>

        <div class="mb-2 d-inline-block">
            <button
                    type="button"
                    class="btn bg-primary text-white float-end adicionar_vendedor"
                    tipo="v"
            >
                <i class="fa-solid fa-plus"></i> Cadastrar Vendedor
            </button>
        </div>

        <div class="form-vendedor">
            <?php if (!$vendedores) {
                echo '<h4 class="text-center">Nenhum vendedor cadastrado</h4>';
            } ?>
        </div>
    </div>

    <div class="my-4">
        <div class="form-check">
            <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="vendedor_procurador_check"
                    name="vendedor_procurador_check"
                    onclick="exibiContainer(this,'vendedor_procurador-container')"
            >
            <label class="form-check-label" for="vendedor_procurador_check">
                Vendedor procurador?
            </label>
        </div>
    </div>

    <div id="vendedor_procurador-container" style="display: none">
        <h4 class="my-2 text-center">Vendedor procurador</h4>

        <div class="mb-2 d-inline-block">
            <button
                    type="button"
                    class="btn bg-primary text-white float-end adicionar_vendedor"
                    tipo="p"
            >
                <i class="fa-solid fa-plus"></i> Cadastrar Vendedor procurador
            </button>
        </div>

        <div class="form-vendedor-procurador">
            <?php if (!$vendedores_procurador) {
                echo '<h4 class="text-center">Nenhum vendedor procurador cadastrado</h4>';
            } ?>
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
                tipo_vendedor: '<?= $vendedor->tipo_vendedor ?>'
            },
            dataType: "html",
            success: function (data) {
                $(".form-vendedor").append(data);
            }
        });

        <?php } ?>

        <?php foreach ($vendedores_procurador as $vendedor_proc){?>

        $.ajax({
            url: "./pages/cadastro_documento/_form_vendedor.php",
            data: {
                vendedor_id: '<?= $vendedor_proc->codigo ?>',
                documento_id: '<?= $vendedor_proc->documento_id; ?>',
                tipo_vendedor: '<?= $vendedor_proc->tipo_vendedor ?>'
            },
            dataType: "html",
            success: function (data) {
                $(".form-vendedor-procurador").append(data);
            }
        });

        <?php } ?>


        $("#vendedor_procurador_check").prop("checked", <?= $d->vendedor_procurador_check ? true : false?>);

        initExibiContainer("<?= $d->vendedor_procurador_check?>", "vendedor_procurador-container");

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
            let tipo_vendedor = $(this).attr('tipo');

            $.ajax({
                url: "./pages/cadastro_documento/_form_vendedor.php",
                data: {
                    documento_id: '<?= $d->codigo ?>',
                    tipo_vendedor
                },
                dataType: "html",
                success: function (data) {

                    if (tipo_vendedor == 'v') {
                        $(".form-vendedor").find('h4').remove();
                        $(".form-vendedor").append(data);
                    } else if (tipo_vendedor == 'p') {
                        $(".form-vendedor-procurador").find('h4').remove();
                        $(".form-vendedor-procurador").append(data);
                    }

                }
            })
        });

        $("#form-vendedor").submit(function (e) {
            e.preventDefault();

            //if (!form.valid()) return false;

            var formData = $(this).serializeArray();

            if (doc_id) {
                formData.push({
                    name: "doc_id",
                    value: doc_id,
                });
            }

            formData.push({
                name: "vendedor_procurador_check",
                value: $("#vendedor_procurador_check").is(":checked") ? 1 : 0,
            });

            $.ajax({
                url: "./pages/cadastro_documento/vendedor.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                success: function (data) {
                    //window.localStorage.setItem('doc_id', data.codigo);


                    $.ajax({
                        url: "./pages/cadastro_documento/comprador.php",
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
