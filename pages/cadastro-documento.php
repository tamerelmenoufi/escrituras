<?php
include './config/includes.php';

?>

<style>
    #cadastro-documento .nav-link.active {
        background-color: var(--color-primary) !important;
        color: #FFFFFF !important;
    }

    #cadastro-documento a.nav-link {
        color: var(--color-primary) !important;
    }
</style>

<div id="cadastro-documento">
    <div class="container">
        <h2 class="text-center">Cadastro de documento</h2>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 my-4">

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

                        <a
                                class="nav-link"
                                id="anexo-tab"
                                href="#anexo">Anexo</a>
                    </div>
                </nav>

                <div class="tab-content py-4">
                    <div class="tab-pane fade show active content-pane" id=""></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function exibiContainer(input, id_container) {
        if ($(input).is(":checked")) {
            $(`#${id_container}`).show();
        } else {
            let container = $(`#${id_container}`);
            container.hide();
            container.find('input, select').val('');
        }
    }

    function initExibiContainer(value, id_container) {
        if (value === '1') $(`#${id_container}`).show();
    }

    $(document).ready(function () {
        jQuery.extend(jQuery.validator.messages, {
            email: 'Por favor insira um endereço de e-mail válido.'
        });

        jQuery.validator.setDefaults({
            errorClass: 'text-danger is-invalid',
            validClass: 'text-success is-valid',
            errorPlacement: function () {
                return false;
            },
        });


        $("#nav-tab a").click(function (e) {
            e.preventDefault();
        });


        $(document).on("click", ".btn_next", function (e) {
            var form = $('form');

            if (form.length > 0 && !$(form[0]).valid()) return false;

            var next_tab = $('#nav-tab > .active')

            $('#nav-tab').find('a').removeClass('active');
            next_tab.next('a').addClass('active');
        });


        $("#nav-tab").click(function(){
            $("#nav-tab a").removeClass('active');
            $(this).find("a").addClass('active');
            console.log('clicando na TAB');
        });


        $(document).on("click", ".btn_prev", function (e) {
            var prev_tab = $('#nav-tab > .active');

            $('#nav-tab').find('a').removeClass('active');
            prev_tab.prev('a').addClass('active');

        });

        var doc_id = window.localStorage.getItem('doc_id');

        $.ajax({
            url: "./pages/cadastro_documento/documento.php",
            data: {doc_id},
            success: function (data) {
                $(".content-pane").html(data);
            }
        });
    });

    $(function () {

        //Adicionar mascara de telefones


        /*$("#form-cadastro-documento").submit(function (e) {
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
                value: JSON.stringify(coordenadas)
            });

            $.ajax({
                url: "./pages/actions/actionCadastro_documento.php",
                method: "POST",
                data: formData, //$(this).serializeArray(),
                success: function (data) {
                    if (data === "ok") {
                        alert('Dados salvos com sucesso!');
                        window.location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        });*/
    });

</script>