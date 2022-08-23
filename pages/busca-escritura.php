<style>
    .topico{
        padding-left:10px;
    }
    .resultado_busca{
        min-height:300px;
    }
</style>
<div class="container-fluid py-4">
    <h1 class="text-center">Busca Grátis</h1>
    <h5 class="text-center mb-5">
        Seja bem vindo, selecione uma das opções abaixo e digite as informações para a busca!
    </h5>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary dropdown-toggle rotulo_busca" campo="aleatorio" type="button" data-bs-toggle="dropdown" aria-expanded="false">Busca Aleatória</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item opc" mask="unmask" info="Digite a informação desejada separando por vírgula. Ex: cpf, nome, edereço, etc" rotulo="Busca Aleatória " href="#">Busca Aleatória</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="topico"><b>Comprador</b></li>
                        <li><a class="dropdown-item opc" mask="unmask" info="Digite o nome completo" campo='comprador_nome' rotulo="Comprador Nome" href="#">Nome</a></li>
                        <li><a class="dropdown-item opc" mask="999.999.999-99" info="Digite o número do CPF" campo='comprador_cpf' rotulo="Comprador CPF" href="#">CPF</a></li>
                        <li><a class="dropdown-item opc" mask="unmask" rotulo="Comprador Razão Social" campo='comprador_razao_social' info="Digite o nome da Razão Social" href="#">Razão Social</a></li>
                        <li><a class="dropdown-item opc" mask="99.999.999/9999-99" info="Digite o número do CNPJ" campo='comprador_cnpj' rotulo="Comprador CNPJ" href="#">CNPJ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="topico"><b>Vendedor</b></li>
                        <li><a class="dropdown-item opc" mask="unmask" info="Digite o nome completo" campo='vendedor_nome' rotulo="Vendedor Nome" href="#">Nome</a></li>
                        <li><a class="dropdown-item opc" mask="999.999.999-99" info="Digite o número do CPF" campo='vendedor_cpf' rotulo="Vendedor CPF" href="#">CPF</a></li>
                        <li><a class="dropdown-item opc" mask="unmask" rotulo="Comprador Razão Social" campo='vendedor_razao_social' rotulo="Vendedor Razão Social" href="#">Razão Social</a></li>
                        <li><a class="dropdown-item opc" mask="99.999.999/9999-99" info="Digite o número do CNPJ" campo='vendedor_cnpj' rotulo="Vendedor CNPJ" href="#">CNPJ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item opc" mask="unmask" info="Rua, número, bairro, cidade, cep" campo='aleatorio' rotulo="Endereço do Imóvel " href="#">Endereço do Imóvel</a></li>
                    </ul>
                    <input type="text" id="texto_busca" class="form-control" placeholder="Digite a informação desejada separando por vírgula. Ex: cpf, nome, edereço, etc">
                    <button type="button" class="btn btn-success px-4 buscar">Buscar</button>
                </div>
            </div>
        </div>

        <div class="resultado_busca"></div>

    </div>

<script>
    $(function(){
        $(".opc").click(function(){
            opc = $(this).attr("rotulo");
            mask = $(this).attr("mask");
            info = $(this).attr("info");
            campo = $(this).attr("campo");

            $(".rotulo_busca").text(opc);
            $(".rotulo_busca").attr("campo",campo);

            if(mask == 'unmask'){
                $('#texto_busca').unmask();
            }else{
                $('#texto_busca').mask(mask);
            }
            $('#texto_busca').attr("placeholder",info);
            $('#texto_busca').val('');
            $(".resultado_busca").html('');
        })

        $(".buscar").click(function(){
            busca = $('#texto_busca').val();
            campo = $('.rotulo_busca').attr("campo");
            if(busca){
                $.ajax({
                    url:"pages/busca-resultado.php",
                    type:"POST",
                    data:{
                        busca,
                        campo
                    },
                    success:function(dados){
                        $(".resultado_busca").html(dados);
                    }
                });
            }else{
                $.alert('Preencha o campo de busca !!!')
            }
        });

    })
</script>

    <!-- <form method="post" action="actions/teste.php">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="mb-3">
                    <label for="cidade" class="col-form-label">
                        Selecione a Cidade onde o imóvel se localiza <span class="text-danger">*</span>
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">
                        Selecione o Estado da federação onde o imóvel se localiza
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">
                        Que tipo de imóvel está procurando (ex casa, apartamento, fazenda, etc)
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">
                        Selecione se o imóvel está situado em rua, avenida, travessa, beco, viela, etc
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">
                        Bairro do imóvel
                    </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">Digite o endereço completo</label>

                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <label for="estado" class="col-form-label">CEP do imóvel</label>

                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success px-4">Buscar</button>
                </div>
            </div>
        </div>
    </form> -->

</div>