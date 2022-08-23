<div class="container-fluid py-4">
    <h1 class="text-center">Busca Grátis</h1>

    <h5 class="text-center mb-5">
        Seja bem vindo, preencha alguns parâmetros para fazermos sua busca!
    </h5>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Dropdown</button>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div role="separator" class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <input type="text" class="form-control" aria-label="Text input with dropdown button">
    </div>



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