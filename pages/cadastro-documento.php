<?php
include './config/includes.php';

?>

<div class="container-fluid">
    <h1 class="text-center">Cadastro de documento</h1>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 my-4">
            <form action="" method="post" id="form-cadastro-documento">
                <nav>
                    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                        <a
                                class="nav-link active"
                                id="documento-tab"
                                data-bs-toggle="tab"
                                href="#documento">Documento</a>

                        <a
                                class="nav-link"
                                id="vendedor-tab"
                                data-bs-toggle="tab"
                                href="#vendedor">Vendedor</a>

                        <a
                                class="nav-link"
                                id="comprador-tab"
                                data-bs-toggle="tab"
                                href="#comprador">Comprador</a>

                        <a
                                class="nav-link"
                                id="endereco-tab"
                                data-bs-toggle="tab"
                                href="#endereco">Endereço</a>

                        <a
                                class="nav-link"
                                id="mapa-tab"
                                data-bs-toggle="tab"
                                href="#mapa">Mapa</a>
                    </div>
                </nav>

                <div class="tab-content py-4">

                    <div class="tab-pane fade show active" id="documento">

                        <!-- Documentos-->

                        <div class="mb-3">
                            <label for="cartorio" class="form-label">Cartório</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="cartorio"
                                    name="cartorio"
                                    aria-describedby="cartorio"
                                    required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="tipo_documento" class="form-label">Tipo de documento</label>
                            <select
                                    class="form-control"
                                    id="tipo_documento"
                                    name="tipo_documento"
                                    aria-describedby="tipo_documento"
                                    required
                            >
                                <option value=""></option>
                                <?php
                                $query_tipo_documento = "SELECT * FROM aux_tipo_documento WHERE deletado = '1'";
                                $result = mysqli_query($con, $query_tipo_documento);

                                while ($row = mysqli_fetch_object($result)): ?>
                                    <option value="<?= $row->codigo ?>"><?= $row->descricao ?></option>
                                <?php endwhile; ?>
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="tipo_imovel" class="form-label">Tipo de Imóvel</label>
                            <select
                                    type="text"
                                    class="form-control"
                                    id="tipo_imovel"
                                    name="tipo_imovel"
                                    aria-describedby="tipo_imovel"
                            >
                                <option value=""></option>
                                <?php
                                $query_tipo_imovel = "SELECT * FROM aux_tipo_imovel WHERE situacao != '1'";
                                $result = mysqli_query($con, $query_tipo_documento);

                                while ($row = mysqli_fetch_object($result)): ?>
                                    <option value="<?= $row->codigo ?>"><?= $row->nome ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nivel_imovel" class="form-label">Nivel do imóvel</label>
                            <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    id="nivel_imovel"
                                    name="nivel_imovel"
                                    aria-describedby="nivel_imovel"
                            >
                        </div>

                        <!-- Documentos-->

                    </div>

                    <div class="tab-pane fade" id="vendedor">

                        <!-- Vendedor -->

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
                                        >
                                            <option value=""></option>
                                        </select>
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

                        <div id="vendedor_procurador-container">
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
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="vendedor_procurador_estado"
                                                aria-describedby="vendedor_procurador_estado"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="vendedor_procurador_cidade" class="form-label">Cidade</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="vendedor_procurador_cidade"
                                                aria-describedby="vendedor_procurador_cidade"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="vendedor_procurador_bairro" class="form-label">Bairro</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="vendedor_procurador_bairro"
                                                aria-describedby="vendedor_procurador_bairro"
                                        >
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

                        <!-- Vendedor -->

                    </div>

                    <div class="tab-pane fade" id="comprador">

                        <!-- Comprador -->
                        <div id="comprador-container">
                            <h4 class="my-2 text-center">Comprador</h4>

                            <div class="mb-3">
                                <label for="comprador_tipo" class="form-label">Tipo de comprador</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="comprador_tipo"
                                        aria-describedby="comprador_tipo"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="comprador_nome" class="form-label">Nome do comprador</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="comprador_nome"
                                        aria-describedby="comprador_nome"
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
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_estado"
                                                aria-describedby="comprador_estado"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="comprador_cidade" class="form-label">Cidade</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_cidade"
                                                aria-describedby="comprador_cidade"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="comprador_bairro" class="form-label">Bairro</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_bairro"
                                                aria-describedby="comprador_bairro"
                                        >
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

                        <div id="comprador-procurador-container">
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
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_procurador_estado"
                                                aria-describedby="comprador_procurador_estado"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="comprador_procurador_cidade" class="form-label">Cidade</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_procurador_cidade"
                                                aria-describedby="comprador_procurador_cidade"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="comprador_procurador_bairro" class="form-label">Bairro</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="comprador_procurador_bairro"
                                                aria-describedby="comprador_procurador_bairro"
                                        >
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
                        <!-- Comprador -->

                    </div>

                    <div class="tab-pane fade" id="endereco">

                        <!-- Endereço -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select
                                    class="form-control"
                                    id="estado"
                                    name="estado"
                                    aria-describedby="estado"
                                    required
                            >
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="cidade"
                                    aria-describedby="cidade"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="cep"
                                    aria-describedby="cep"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="bairro"
                                    aria-describedby="bairro"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="rua"
                                    aria-describedby="rua"
                            >
                        </div>

                        <!-- Endereço -->

                    </div>

                    <div class="tab-pane fade" id="mapa">

                        <!-- Mapa -->

                        <div class="mb-3">
                            <label for="coordenadas" class="form-label">Coordenadas</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="coordenadas"
                                    aria-describedby="coordenadas"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="poligono" class="form-label">Poligono</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    id="poligono"
                                    aria-describedby="poligono"
                            >
                        </div>
                        <!-- Mapa -->

                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-auto">
                        <button
                                type="button"
                                class="btn btn-secondary"
                                data-enchanter="previous"
                        >
                            Voltar
                        </button>
                    </div>
                    <div class="col-auto">
                        <button
                                type="button"
                                class="btn btn-primary"
                                data-enchanter="next"
                        >
                            Proximo
                        </button>

                        <button
                                type="submit"
                                class="btn btn-primary"
                                data-enchanter="finish"
                        >
                            Finalizar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="assets/js/enchanter.js"></script>


<script>
    $(document).ready(function () {
        $('#vendedor_cpf').mask('000.000.000-00', {clearIfNotMatch: true});

        var registrationForm = $('#form-cadastro-documento');

        var formValidate = $('#form-cadastro-documento').validate({
            errorClass: 'is-invalid',
            errorPlacement: () => false
        });

        const wizard = new Enchanter('form-cadastro-documento', {}, {
            onNext: () => {
                if (!registrationForm.valid()) {
                    formValidate.focusInvalid();
                    return false;
                }
            }
        });
    });

    $(function () {

        $("#vendedor_estado").change(function () {
            let estado = $(this).val();

            $.ajax({
                url: "./pages/lista/cidades.php",
                type: "POST",
                data: {
                    estado,
                },
                dataType: 'html',
                success: function (dados) {
                    $('#vendedor_cidade').html(dados);
                }
            });
        });


    })
</script>