<div id="vendedor-container">
    <h4 class="my-2 text-center">Vendedor</h4>

    <div class="mb-3">
        <label for="vendedor_tipo" class="form-label">Tipo de vendedor</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_tipo"
            name="vendedor_tipo"
            aria-describedby="vendedor_tipo"
            required
        >
    </div>

    <div class="mb-3">
        <label for="vendedor_nome" class="form-label">Nome do vendedor</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_nome"
            name="vendedor_nome"
            aria-describedby="vendedor_nome"
            required
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_rg" class="form-label">RG</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_rg"
                    name="vendedor_rg"
                    aria-describedby="vendedor_rg"
                    required
                >
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_cpf" class="form-label">CPF</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_cpf"
                    aria-describedby="vendedor_cpf"
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="vendedor_cnpj" class="form-label">CNPJ</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_cnpj"
            aria-describedby="vendedor_cnpj"
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_inscricao_estadual" class="form-label">Inscrição
                    estadual</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_inscricao_estadual"
                    aria-describedby="vendedor_inscricao_estadual"
                >
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_inscricao_municipal" class="form-label">Inscrição
                    municipal</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_inscricao_municipal"
                    aria-describedby="vendedor_inscricao_municipal"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_estado" class="form-label">Estado</label>
                <select
                    type="text"
                    class="form-control"
                    id="vendedor_estado"
                    aria-describedby="vendedor_estado"
                    onchange="select_localidade('vendedor_estado','vendedor_cidade','cidades')"
                >
                    <option value=""></option>
                    <?php
                    $query_estados = "SELECT * FROM aux_estados WHERE situacao = '0'";
                    $result = mysqli_query($con, $query_estados);
                    while ($row = mysqli_fetch_object($result)):?>
                        <option value="<?= $row->codigo ?>"><?= $row->nome ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_cidade" class="form-label">Cidade</label>
                <select
                    class="form-control"
                    id="vendedor_cidade"
                    aria-describedby="vendedor_cidade"
                    onchange="select_localidade('vendedor_cidade','vendedor_bairro','bairros')"
                    required
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_bairro" class="form-label">Bairro</label>
                <select
                    class="form-control"
                    id="vendedor_bairro"
                    aria-describedby="vendedor_bairro"
                    required
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="co-md-3">
                <div class="mb-3">
                    <label for="vendedor_rua" class="form-label">Rua</label>
                    <input
                        type="text"
                        class="form-control"
                        id="vendedor_rua"
                        aria-describedby="vendedor_rua"
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_numero" class="form-label">Número</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_numero"
                    aria-describedby="vendedor_numero"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_telefone" class="form-label">Telefone</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_telefone"
                    aria-describedby="vendedor_telefone"
                >
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label for="vendedor_email" class="form-label">E-Mail</label>
                <input
                    type="email"
                    class="form-control"
                    id="vendedor_email"
                    aria-describedby="vendedor_email"
                    required
                >
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="form-check">
        <input
            class="form-check-input"
            type="checkbox"
            value=""
            id="check-vendedor-procurador"
            onclick="exibiContainer(this,'vendedor_procurador-container')"
        >
        <label class="form-check-label" for="check-vendedor-procurador">
            Vendedor procurador
        </label>
    </div>
</div>

<div id="vendedor_procurador-container" style="display: none">
    <h4 class="my-2 text-center">Vendedor procurador</h4>

    <div class="mb-3">
        <label for="vendedor_procurador_tipo" class="form-label">Tipo de vendedor</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_procurador_tipo"
            aria-describedby="vendedor_procurador_tipo"
        >
    </div>

    <div class="mb-3">
        <label for="vendedor_procurador_nome" class="form-label">Nome do vendedor</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_procurador_nome"
            aria-describedby="vendedor_procurador_nome"
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_procurador_rg" class="form-label">RG</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_rg"
                    aria-describedby="vendedor_procurador_rg"
                >
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="vendedor_procurador_cpf" class="form-label">CPF</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_cpf"
                    aria-describedby="vendedor_procurador_cpf"
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="vendedor_procurador_cnpj" class="form-label">CNPJ</label>
        <input
            type="text"
            class="form-control"
            id="vendedor_procurador_cnpj"
            aria-describedby="vendedor_procurador_cnpj"
        >
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_procurador_estado" class="form-label">Estado</label>
                <select
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_estado"
                    aria-describedby="vendedor_procurador_estado"
                    onchange="select_localidade('vendedor_procurador_estado','vendedor_procurador_cidade','cidades')"
                >
                    <option value=""></option>
                    <?php
                    $query_estados = "SELECT * FROM aux_estados WHERE situacao = '0'";
                    $result = mysqli_query($con, $query_estados);
                    while ($row = mysqli_fetch_object($result)):?>
                        <option value="<?= $row->codigo ?>"><?= $row->nome ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_procurador_cidade" class="form-label">Cidade</label>
                <select
                    class="form-control"
                    id="vendedor_procurador_cidade"
                    aria-describedby="vendedor_procurador_cidade"
                    onchange="select_localidade('vendedor_procurador_cidade','vendedor_procurador_bairro','bairros')"
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_procurador_bairro" class="form-label">Bairro</label>
                <select
                    class="form-control"
                    id="vendedor_procurador_bairro"
                    aria-describedby="vendedor_procurador_bairro"
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="co-md-3">
                <div class="mb-3">
                    <label for="vendedor_procurador_rua" class="form-label">Rua</label>
                    <input
                        type="text"
                        class="form-control"
                        id="vendedor_procurador_rua"
                        aria-describedby="vendedor_procurador_rua"
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_procurador_numero" class="form-label">Número</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_numero"
                    aria-describedby="vendedor_procurador_numero"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="vendedor_procurador_telefone"
                       class="form-label">Telefone</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_telefone"
                    aria-describedby="vendedor_procurador_telefone"
                >
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label for="vendedor_procurador_email" class="form-label">E-Mail</label>
                <input
                    type="text"
                    class="form-control"
                    id="vendedor_procurador_email"
                    aria-describedby="vendedor_procurador_email"
                >
            </div>
        </div>
    </div>
</div>