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
        <div class="col-md-6">
            <div style="border-radius:8px; margin-left:50px; width:100%; height:150px; background-color:#1a1f24; margin-top:15%; margin-bottom:15%; padding:20px;">
                <p style=" margin-top:5px; color:#fff;">Ainda não tem cadastro?</p>
                <button class="btn btn-primary" type="button" style="width:calc(100% - 50px);">FAÇA SEU CADASTRO</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="padding:20px;">
                <form id="form-login" method="post" role="form" class="">

                    <input type="hidden" name="acao" value="login">

                    <div class="row">
                        <h5
                                class="text-left"
                                style="color: rgba(var(--color-secondary-dark-rgb), 1);"
                        >
                            Faça seu login
                        </h5>

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
                                    style="color: rgba(var(--color-secondary-dark-rgb), 0.7);"
                                    required
                            >
                        </div>
                        <div class="form-group mt-3">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1" style="font-size:12px;"> Declaro que concordo com os Termos de Privacidade conforme a Lei Geral de Proteção de Dados.</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button class="button-primary" type="submit" style="width:100%;">Entrar</button>
                    </div>
                    <p><a href='#'>Esqueceu a senha? Clique aqui!</a></p>
                </form>
            </div>
        </div>
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