<div id="comprador-container">
    <h4 class="my-2 text-center">Comprador</h4>

    <div class="mb-3">
        <label for="comprador_tipo" class="form-label">Tipo de comprador</label>
        <input
                type="text"
                class="form-control"
                id="comprador_tipo"
                aria-describedby="comprador_tipo"
                required
        >
    </div>

    <div class="mb-3">
        <label for="comprador_nome" class="form-label">Nome do comprador</label>
        <input
                type="text"
                class="form-control"
                id="comprador_nome"
                aria-describedby="comprador_nome"
                required
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_rg" class="form-label">RG</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_rg"
                        aria-describedby="comprador_rg"
                        required
                >
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_cpf" class="form-label">CPF</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_cpf"
                        aria-describedby="comprador_cpf"
                        required
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="comprador_cnpj" class="form-label">CNPJ</label>
        <input
                type="text"
                class="form-control"
                id="comprador_cnpj"
                aria-describedby="comprador_cnpj"
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_inscricao_estadual" class="form-label">Inscrição
                    estadual</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_inscricao_estadual"
                        aria-describedby="comprador_inscricao_estadual"
                >
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_inscricao_municipal" class="form-label">Inscrição
                    municipal</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_inscricao_municipal"
                        aria-describedby="comprador_inscricao_municipal"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_estado" class="form-label">Estado</label>
                <select
                        type="text"
                        class="form-control"
                        id="comprador_estado"
                        aria-describedby="comprador_estado"
                        onchange="select_localidade('comprador_estado','comprador_cidade','cidades')"
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
                <label for="comprador_cidade" class="form-label">Cidade</label>
                <select
                        class="form-control"
                        id="comprador_cidade"
                        aria-describedby="comprador_cidade"
                        onchange="select_localidade('comprador_cidade','comprador_bairro','bairros')"
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_bairro" class="form-label">Bairro</label>
                <select
                        class="form-control"
                        id="comprador_bairro"
                        aria-describedby="comprador_bairro"
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
                    <label for="comprador_rua" class="form-label">Rua</label>
                    <input
                            type="text"
                            class="form-control"
                            id="comprador_rua"
                            aria-describedby="comprador_rua"
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_numero" class="form-label">Número</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_numero"
                        aria-describedby="comprador_numero"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_telefone" class="form-label">Telefone</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_telefone"
                        aria-describedby="comprador_telefone"
                >
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label for="comprador_email" class="form-label">E-Mail</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_email"
                        aria-describedby="comprador_email"
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
                id="check-comprador-procurador"
                onclick="exibiContainer(this,'comprador-procurador-container')"
        >
        <label class="form-check-label" for="check-comprador-procurador">
            Comprador procurador?
        </label>
    </div>
</div>

<div id="comprador-procurador-container" style="display: none">
    <h4 class="my-2 text-center">Comprador procurador</h4>

    <div class="mb-3">
        <label for="comprador_procurador_tipo" class="form-label">Tipo de comprador</label>
        <input
                type="text"
                class="form-control"
                id="comprador_procurador_tipo"
                aria-describedby="comprador_procurador_tipo"
        >
    </div>

    <div class="mb-3">
        <label for="comprador_procurador_nome" class="form-label">Nome do comprador</label>
        <input
                type="text"
                class="form-control"
                id="comprador_procurador_nome"
                aria-describedby="comprador_procurador_nome"
        >
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_procurador_rg" class="form-label">RG</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_procurador_rg"
                        aria-describedby="comprador_procurador_rg"
                >
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="comprador_procurador_cpf" class="form-label">CPF</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_procurador_cpf"
                        aria-describedby="comprador_procurador_cpf"
                >
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="comprador_procurador_cnpj" class="form-label">CNPJ</label>
        <input
                type="text"
                class="form-control"
                id="comprador_procurador_cnpj"
                aria-describedby="comprador_procurador_cnpj"
        >
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_procurador_estado" class="form-label">Estado</label>
                <select
                        type="text"
                        class="form-control"
                        id="comprador_procurador_estado"
                        aria-describedby="comprador_procurador_estado"
                        onchange="select_localidade('comprador_procurador_estado','comprador_procurador_cidade','cidades')"
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
                <label for="comprador_procurador_cidade" class="form-label">Cidade</label>
                <select
                        class="form-control"
                        id="comprador_procurador_cidade"
                        aria-describedby="comprador_procurador_cidade"
                        onchange="select_localidade('comprador_procurador_cidade','comprador_procurador_bairro','bairros')"
                >
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_procurador_bairro" class="form-label">Bairro</label>
                <select
                        class="form-control"
                        id="comprador_procurador_bairro"
                        aria-describedby="comprador_procurador_bairro"
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
                    <label for="comprador_procurador_rua" class="form-label">Rua</label>
                    <input
                            type="text"
                            class="form-control"
                            id="comprador_procurador_rua"
                            aria-describedby="comprador_procurador_rua"
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_procurador_numero" class="form-label">Número</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_procurador_numero"
                        aria-describedby="comprador_procurador_numero"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="comprador_procurador_telefone"
                       class="form-label">Telefone</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_procurador_telefone"
                        aria-describedby="comprador_procurador_telefone"
                >
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label for="comprador_procurador_email" class="form-label">E-Mail</label>
                <input
                        type="text"
                        class="form-control"
                        id="comprador_procurador_email"
                        aria-describedby="comprador_procurador_email"
                >
            </div>
        </div>
    </div>
</div>