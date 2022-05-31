<?php
include './config/includes.php';

?>

<script>
    $(function () {
        marker = null;

        geocoder = new google.maps.Geocoder();

        //@formatter:off
        mapa = new google.maps.Map(document.getElementById("map"), {
            zoom              : 14,
            zoomControl       : true,
            mapTypeControl    : false,
            draggable         : true,
            scaleControl      : false,
            scrollwheel       : true,
            navigationControl : false,
            streetViewControl : false,
            fullscreenControl : false,
        });

        marker = new google.maps.Marker();

        //@formatter:on
    });
</script>
<div class="container-fluid">
    <h1 class="text-center">Cadastro de documento</h1>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 my-4">
            <form action="" method="post" id="form-cadastro-documento">
                <nav>
                    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                        <a
                                class="nav-link active"
                                id="documento-tab"
                                href="#documento">Documento</a>

                        <a
                                class="nav-link"
                                id="vendedor-tab"
                                href="#vendedor">Vendedor</a>

                        <a
                                class="nav-link"
                                id="comprador-tab"
                                href="#comprador">Comprador</a>

                        <a
                                class="nav-link"
                                id="endereco-tab"
                                href="#endereco">Endereço</a>

                        <a
                                class="nav-link"
                                id="mapa-tab"
                                href="#mapa">Mapa</a>
                    </div>
                </nav>

                <div class="tab-content py-4">

                    <div class="tab-pane fade show active" id="documento">

                        <!-- Documentos-->
                        <?php include "cadastro_documento_views/documento.php"; ?>
                        <!-- Documentos-->

                    </div>

                    <div class="tab-pane fade" id="vendedor">

                        <!-- Vendedor -->
                        <?php include "cadastro_documento_views/vendedor.php" ?>
                        <!-- Vendedor -->

                    </div>

                    <div class="tab-pane fade" id="comprador">

                        <!-- Comprador -->
                        <?php include "cadastro_documento_views/comprador.php"; ?>
                        <!-- Comprador -->

                    </div>

                    <div class="tab-pane fade" id="endereco">

                        <!-- Endereço -->
                        <?php include "cadastro_documento_views/endereco.php" ?>
                        <!-- Endereço -->

                    </div>

                    <div class="tab-pane fade" id="mapa">

                        <!-- Mapa -->
                        <?php include "cadastro_documento_views/mapa.php" ?>
                        <!-- Mapa -->

                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-auto">
                        <button
                                type="button"
                                class="btn btn-secondary"
                                data-enchanter="previous"
                        >
                            Voltar
                        </button>
                    </div>
                    <div class="col-auto">
                        <button
                                type="button"
                                class="btn btn-primary"
                                data-enchanter="next"
                        >
                            Proximo
                        </button>

                        <button
                                type="submit"
                                class="btn btn-primary finish"
                                data-enchanter="finish"
                        >
                            Finalizar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div
        class="modal fade"
        id="staticBackdrop"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
        style="display: <?= isset($_SESSION['alert']) ? 'block' : 'none'; ?>"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $_SESSION['alert']['title'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $_SESSION['alert']['content']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['alert']) ?>

<script src="assets/js/enchanter.js"></script>

<script>

    function select_localidade(select, select_to, url) {
        let valor = $(`#${select}`).val();

        $.ajax({
            url: `./pages/lista/${url}.php`,
            method: 'POST',
            data: {valor},
            dataType: 'html',
            success: function (data) {
                $(`#${select_to}`).html(data);
            }
        });
    }

    function exibiContainer(input, id_container) {
        if ($(input).is(":checked")) {
            $(`#${id_container}`).show();
        } else {
            let container = $(`#${id_container}`);
            container.hide();
            container.find('input, select').val('');
        }
    }

    $(document).ready(function () {
        //Adiciona mascara de CPF
        $('#vendedor_cpf, #vendedor_comprador_cpf, #comprador_cpf, #comprador_procurador_cpf')
            .mask('000.000.000-00', {clearIfNotMatch: true});
        //Adicionar mascara de telefones
        $('#vendedor_telefone, #vendedor_comprador_telefone, #comprador_telefone, #comprador_procurador_telefone')
            .mask('(00) 90000-0000', {clearIfNotMatch: true});

        var registrationForm = $('#form-cadastro-documento');

        var formValidate = $('#form-cadastro-documento').validate({
            errorClass: 'is-invalid',
            errorPlacement: () => false
        });

        const wizard = new Enchanter('form-cadastro-documento', {}, {
            onNext: () => {
                if (!registrationForm.valid()) {
                    formValidate.focusInvalid();
                    return false;
                }
            }
        });
    });

    $(function () {
        $("#form-cadastro-documento .nav-link").click(function (e) {
            e.preventDefault();
        });

        $("#form-cadastro-documento").submit(function (e) {
            e.preventDefault();
            vertices = poligono.getPath();
            var formData = $(this).serializeArray();
            var coordenadas = [];

            for (let i = 0; i < vertices.getLength(); i++) {
                const xy = vertices.getAt(i);

                coordenadas.push({
                    "lat": xy.lat(),
                    "lng": xy.lng()
                });
            }

            formData.push({
                name: "coordenadas",
                value: coordenadas
            });

            $.ajax({
                url: "./pages/actions/actionCadastro_documento.php",
                method: "POST",
                data: $(this).serializeArray(),
                success: function (data) {
                    if (data === "ok") {
                        alert('Dados salvos com sucesso!');
                        window.location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        });
    });

</script>