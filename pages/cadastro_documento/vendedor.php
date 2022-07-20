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
    $result = mysqli_query($con, "SELECT codigo, vendedor_procurador_check FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);

    $query_vendedor = "SELECT * FROM vendedor_comprador "
        . "WHERE documento_id = '{$d->codigo}' ORDER BY tipo = 'v'";

    $result_vendedores = mysqli_query($con, $query_vendedor);

    $vendedores = [];
    $vendedores_procurador = [];

    while ($d_vendedor = mysqli_fetch_object($result_vendedores)) {

        if ($d_vendedor->tipo == 'v') {
            $vendedores[] = $d_vendedor;
        } elseif ($d_vendedor->tipo == 'p') {
            $vendedores_procurador[] = $d_vendedor;
        }
    }
}

?>

<form id="form-vendedor" class="needs-validation" novalidate>

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

                <div class="form-vendedor">
                    <?php if (!$vendedores) {
                        #echo '<h5 class="text-center my-3">Nenhum vendedor cadastrado</h5>';
                    } ?>
                </div>
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

        <?php foreach ($vendedores_procurador as $vendedor_proc){?>

        $.ajax({
            url: "./pages/cadastro_documento/_form_vendedor.php",
            data: {
                vendedor_id: '<?= $vendedor_proc->codigo ?>',
                documento_id: '<?= $vendedor_proc->documento_id; ?>',
                tipo: '<?= $vendedor_proc->tipo ?>'
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
            let tipo = $(this).attr('tipo');

            $.ajax({
                url: "./pages/cadastro_documento/_form_vendedor.php",
                data: {
                    documento_id: '<?= $d->codigo ?>',
                    tipo
                },
                dataType: "html",
                success: function (data) {

                    if (tipo == 'v') {
                        //$(".form-vendedor").find('h4').remove();
                        $(".form-vendedor").append(data);
                    } else if (tipo == 'p') {
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
