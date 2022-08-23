<div class="container-fluid py-4">
    <h1 class="text-center">Busca Grátis</h1>

    <h5 class="text-center mb-5">
        Seja bem vindo, selecione uma das opções abaixo e digite as informações para a busca!
    </h5>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary dropdown-toggle rotulo_busca" type="button" data-bs-toggle="dropdown" aria-expanded="false">Buscar por</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><b>Comprador</b></a></li>
                        <li><a class="dropdown-item opc" href="#">Nome</a></li>
                        <li><a class="dropdown-item opc" href="#">CPF</a></li>
                        <li><a class="dropdown-item opc" href="#">Razão Social</a></li>
                        <li><a class="dropdown-item opc" href="#">CNPJ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><b>Vendedor</b></a></li>
                        <li><a class="dropdown-item opc" href="#">Nome</a></li>
                        <li><a class="dropdown-item opc" href="#">CPF</a></li>
                        <li><a class="dropdown-item opc" href="#">Razão Social</a></li>
                        <li><a class="dropdown-item opc" href="#">CNPJ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item opc" href="#">Busca Aleatória</a></li>
                    </ul>
                    <input type="text" class="form-control" aria-label="Text input with dropdown button">
                </div>
            </div>
        </div>
    </div>

<script>
    $(function(){
        $(".opc").click(function(){
            opc = $(this).text();
            $(".rotulo_busca").text(opc);
        })
    })
</script>

    <form method="post" action="actions/teste.php">
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
    </form>

</div>