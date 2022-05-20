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
        $query_tipo_documento = "SELECT * FROM aux_tipo_documento WHERE deletado != '1'";
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
        $query_tipo_imovel = "SELECT * FROM aux_tipo_imovel WHERE deletado != '1'";
        $result = mysqli_query($con, $query_tipo_imovel);

        while ($row = mysqli_fetch_object($result)): ?>
            <option value="<?= $row->codigo ?>"><?= $row->descricao ?></option>
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