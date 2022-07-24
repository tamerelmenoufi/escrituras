<?php
include_once "./config/conf.php";

?>

<style>
    input[type=text], input[type=password] {
        height: 48px !important;
        padding: 10px 15px !important;
    }
</style>
<div class="container my-5">
    <div class="row">

        <div class="offset-lg-3 col-lg-6" style="margin-top: 1rem;margin-bottom: 3rem">
            <form id="form-login" method="post" role="form" class="">

                <input type="hidden" name="acao" value="login">

                <div class="row">
                    <h3
                            class="text-center"
                            style="color: rgba(var(--color-secondary-dark-rgb), 1);"
                    >
                        Área de login
                    </h3>

                    <div class="form-group mt-3">
                        <div class="alert alert-danger alert-dismissible msg-error" role="alert"
                             style="display: none">
                            <text></text>
                            <button type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input
                                type="text"
                                name="nome"
                                class="form-control"
                                id="nome"
                                maxlength="45"
                                placeholder="Usuário"
                                onfocus=""
                                style="color: rgba(var(--color-secondary-dark-rgb), 0.7)"
                                required>
                    </div>

                    <div class="form-group mt-3">
                        <input
                                type="password"
                                class="form-control"
                                name="senha"
                                id="senha"
                                maxlength="150"
                                placeholder="Senha"
                                style="color: rgba(var(--color-secondary-dark-rgb), 0.7)"
                                required
                        >
                    </div>
                </div>

                <div class="text-center mt-4 mt-3">
                    <button class="button-primary" type="submit" style="width: 50%">Entrar</button>
                </div>

            </form>
        </div><!-- End Contact Form -->
    </div>
</div>


<script>
    $(function () {
        $("#form-login").submit(function (e) {
            e.preventDefault();

            $("button[type=submit]").attr("disabled", "disabled");

            $.ajax({
                url: "./pages/actions/actionLogin.php",
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {

                    if (data.status) {
                        setTimeout(function () {
                            window.location.href = "<?= $base_url?>";
                        }, 800);
                    } else {
                        $("button[type=submit]").removeAttr("disabled");

                        $.alert({
                            title: 'Erro',
                            content: data.msg,
                            theme: 'bootstrap',
                            type: 'red',
                            icon: 'fa fa-warning',
                        });
                    }
                }
            })
        });

        $(".btn-close").click(function () {
            $(this).parent().fadeOut();
        });
    });
</script>