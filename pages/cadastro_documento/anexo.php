<?php
include_once "../../config/includes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doc_id = $_POST['doc_id'];
    $file = $_FILES;

    $total = count($_FILES['arquivo']['name']);

    for ($i = 0; $i < $total; $i++):
        $tmpFilePath = $_FILES['arquivo']['tmp_name'][$i];

        if ($tmpFilePath != "") :
            $path = "../../storage/documentos";

            if (!is_dir("{$path}/{$doc_id}")) mkdir("{$path}/{$doc_id}");

            $newFilePath = "{$path}/{$doc_id}/{$_FILES['arquivo']['name'][$i]}";

            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                return true;
            }
        endif;
    endfor;
    echo $newFilePath;
    exit();
}

$doc_id = $_GET['doc_id'];

if ($doc_id) {
    $result = mysqli_query($con, "SELECT codigo, coordenadas, poligono FROM documentos WHERE codigo = '{$doc_id}'");
    $d = mysqli_fetch_object($result);
}
?>
<!-- CSS -->
<link rel="stylesheet" href="<?= $base_url; ?>assets/vendor/kartik-v-bootstrap-fileinput/css/fileinput.min.css">
<!-- CSS -->

<form id="form-anexo" class="needs-validation" novalidate enctype="multipart/form-data">
    <div id="anexo-container">
        <h3 class="text-center">Anexos de documentos</h3>

        <div class="col-md-12">
            <h6>
                incluir uma cópia do documento original contendo todas as informações inseridas nas etapas dos
                cadastros
                anteriores
            </h6>
        </div>

    </div>

    <div class="mb-3">
        <label for="arquivo" class="form-label">Arquivo</label>

        <div class="file-loading">
            <input id="arquivo" name="arquivo[]" type="file" multiple>
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
                <button type="button" class="btn bg-primary salvar">Salvar</button>
            </div>
        </div>
    </div>

    <input type="hidden" id="codigo" value="<?= $d->codigo ?>">

</form>


<script src="<?= $base_url; ?>assets/vendor/kartik-v-bootstrap-fileinput/js/fileinput.min.js"></script>
<script
        src="<?= $base_url; ?>assets/vendor/kartik-v-bootstrap-fileinput/js/locales/pt-BR.js"
        type="text/javascript"
></script>
<script
        src="<?= $base_url; ?>assets/vendor/kartik-v-bootstrap-fileinput/themes/explorer-fa5/theme.js"
        type="text/javascript"
></script>

<script>
    $(document).ready(function () {
        $("#arquivo").fileinput({
            language: 'pt-BR',
            allowedFileExtensions: ['pdf'],
            showUpload: false,
            uploadUrl: '#',
            overwriteInitial: false,
            initialPreviewAsData: true,
        });
    });

    $(function () {
        var doc_id = window.localStorage.getItem('doc_id');

        $("button[voltar]").click(function () {
            $.ajax({
                url: "./pages/cadastro_documento/mapa.php",
                data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            })
        });

        $(".salvar").click(function () {
            var data = new FormData($('#form-anexo').get(0));

            data.append('doc_id', doc_id);

            $.ajax({
                url: './pages/cadastro_documento/anexo.php',
                method: 'post',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                }
            });
            return false;
            $.alert({
                title: "Aviso",
                content: "Tem certeza que deseja finalizar o cadastro?",
                columnClass: "medium",
                buttons: {
                    sim: {
                        text: 'sim',
                        action: function () {
                            window.localStorage.setItem('doc_id', '');

                            $.alert({
                                title: 'Sucesso',
                                content: response.msg,
                                buttons: {
                                    ok: {
                                        text: 'Ok',
                                        action: function () {
                                            window.location.href = './cadastro-documento';
                                        }
                                    }
                                }
                            });

                        }
                    },
                    nao: {
                        text: 'Não',
                        action: () => {
                        },
                    }
                }
            })
        });
    });
</script>