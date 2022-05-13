<div class="container-fluid">
    <h1 class="text-center">Cadastro de documento</h1>

    <div class="row">
        <div class="col-md-8 offset-md-2 my-4">
            <div class="d-flex align-items-start">

                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button
                            class="nav-link active"
                            id="v-pills-home-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#documento"
                            type="button"
                            role="tab"
                            aria-controls="documento"
                            aria-selected="true">Documento
                    </button>

                    <button
                            class="nav-link"
                            id="v-pills-profile-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#vendedor"
                            type="button"
                            role="tab"
                            aria-controls="vendedor"
                            aria-selected="false">Vendedor
                    </button>
                    <button
                            class="nav-link"
                            id="v-pills-messages-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#comprador"
                            type="button"
                            role="tab"
                            aria-controls="comprador"
                            aria-selected="false">Comprador
                    </button>

                    <button
                            class="nav-link"
                            id="v-pills-settings-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#endereco"
                            type="button"
                            role="tab"
                            aria-controls="endereco"
                            aria-selected="false">Endereço
                    </button>

                    <button
                            class="nav-link"
                            id="v-pills-settings-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#mapa"
                            type="button"
                            role="tab"
                            aria-controls="mapa"
                            aria-selected="false">Mapa
                    </button>
                </div>

                <div class="tab-content" id="v-pills-tabContent" style="flex: 1">
                    <!-- Documentos-->
                    <div class="tab-pane fade show active" id="documento" role="tabpanel" aria-labelledby="documento">

                        <div class="mb-3">
                            <label for="cartorio" class="form-label">Cartório</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="cartorio"
                                    aria-describedby="cartorio"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="tipo_documento" class="form-label">Tipo de documento</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="tipo_documento"
                                    aria-describedby="tipo_documento"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="tipo_imovel" class="form-label">Tipo de Imóvel</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="tipo_imovel"
                                    aria-describedby="tipo_imovel"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="nivel_imovel" class="form-label">Nivel do imóvel</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="nivel_imovel"
                                    aria-describedby="nivel_imovel"
                            >
                        </div>
                    </div>
                    <!-- Documentos-->

                    <!-- Vendedor -->
                    <div class="tab-pane fade" id="vendedor" role="tabpanel" aria-labelledby="vendedor">

                        <div class="mb-3">
                            <label for="cartorio" class="form-label">Cartório</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="cartorio"
                                    aria-describedby="cartorio"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="vendedor_tipo" class="form-label">Tipo de vendedor</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="vendedor_tipo"
                                    aria-describedby="vendedor_tipo"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="vendedor_nome" class="form-label">Nome do vendedor</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="vendedor_nome"
                                    aria-describedby="vendedor_nome"
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
                                            aria-describedby="vendedor_rg"
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
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="vendedor_estado"
                                            aria-describedby="vendedor_estado"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="vendedor_cidade" class="form-label">Cidade</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="vendedor_cidade"
                                            aria-describedby="vendedor_cidade"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="vendedor_bairro" class="form-label">Bairro</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="vendedor_bairro"
                                            aria-describedby="vendedor_bairro"
                                    >
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
                                            type="text"
                                            class="form-control"
                                            id="vendedor_email"
                                            aria-describedby="vendedor_email"
                                    >
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Vendedor -->

                    <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="endereco">

                    </div>
                    <div class="tab-pane fade" id="mapa" role="tabpanel" aria-labelledby="mapa">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>