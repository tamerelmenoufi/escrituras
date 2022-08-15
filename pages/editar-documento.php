<?php
include './config/includes.php';

$doc_id = $_GET['id'];
?>

<style>
    #editar-documento .nav-link.active {
        background-color: var(--color-primary) !important;
        color: #FFFFFF !important;
    }

    #editar-documento a.nav-link {
        color: var(--color-primary) !important;
    }
</style>

<div id="editar-documento">
    <div class="container-fluid">
        <h2 class="text-center">Editar de documento</h2>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 my-4">

                <nav>
                    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                        <a
                                class="nav-link active"
                                id="documento-tab"
                                href="documento">Documento</a>

                        <a
                                class="nav-link"
                                id="vendedor-tab"
                                href="vendedor">Vendedor</a>

                        <a
                                class="nav-link"
                                id="comprador-tab"
                                href="comprador">Comprador</a>

                        <a
                                class="nav-link"
                                id="endereco-tab"
                                href="endereco">Endereço</a>

                        <a
                                class="nav-link"
                                id="mapa-tab"
                                href="mapa">Mapa</a>
                        <a
                                class="nav-link"
                                id="anexo-tab"
                                href="anexo">Anexo</a>
                    </div>
                </nav>

                <div class="tab-content py-4">
                    <div class="tab-pane fade show active content-pane" id=""></div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="doc_id" value="<?= $doc_id; ?>">

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

        $(".nav-link").click(function(){
            $(".nav-link").removeClass('active');
            $(this).addClass('active');
            local = $(this).attr("href");
            console.log('clicando na TAB' + local);

            $.ajax({
                url: `./pages/editar_documento/${local}.php`,
                // data: {doc_id},
                success: function (data) {
                    $(".content-pane").html(data);
                }
            });

        });


        $(document).on("click", ".btn_next", function (e) {
            var form = $('form')[0];

            if (!$(form).valid()) return false;

            var next_tab = $('#nav-tab > .active')

            $('#nav-tab').find('a').removeClass('active');
            next_tab.next('a').addClass('active');
        });

        $(document).on("click", ".btn_prev", function (e) {
            var prev_tab = $('#nav-tab > .active');

            $('#nav-tab').find('a').removeClass('active');
            prev_tab.prev('a').addClass('active');
        });

        var doc_id = $("#doc_id").val();

        console.log(doc_id);

        $.ajax({
            url: "./pages/editar_documento/documento.php",
            data: {doc_id},
            success: function (data) {
                $(".content-pane").html(data);
            }
        });
    });


</script>