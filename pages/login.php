<?php
include_once "./config/conf.php";

?>
<div class="container my-5">
    <div class="row gy-5 gx-lg-5">

        <div class="col-lg-6 d-flex flex-row justify-content-center align-items-center">
            [IMAGE]
        </div>
        <div class="col-lg-6" style="margin-top: 4rem;">
            <form id="form-login" method="post" role="form">

                <input type="hidden" name="acao" value="login">

                <div class="row">
                    <h3
                            class="text-center"
                            style="color: rgba(var(--color-secondary-dark-rgb), 1)"
                    >
                        Área de login
                    </h3>

                    <div class="form-group mt-3">
                        <div class="alert alert-danger alert-dismissible msg-error" role="alert"
                             style="display: none">
                            <text></text>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome">Usuário</label>
                        <input
                                type="text"
                                name="nome"
                                class="form-control"
                                id="nome"
                                maxlength="45"
                                placeholder=""
                                onfocus=""
                                style="color: rgba(var(--color-secondary-dark-rgb), 0.7)"
                                required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="senha">Senha</label>
                        <input
                                type="password"
                                class="form-control"
                                name="senha"
                                id="senha"
                                maxlength="150"
                                placeholder=""
                                style="color: rgba(var(--color-secondary-dark-rgb), 0.7)"
                                required
                        >
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button class="button-primary" type="submit">Entrar</button>
                </div>

            </form>
        </div><!-- End Contact Form -->
    </div>
</div>

<script>
    $(function () {
        $("#form-login").submit(function (e) {
            e.preventDefault();

            //$(".msg-error").hide();

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
                        $(".msg-error").show().find('text').text(data.msg);

                    }
                }
            })
        });
    });
</script>