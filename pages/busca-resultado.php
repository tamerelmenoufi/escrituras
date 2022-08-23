<?php
include_once "../config/includes.php";
?>
<div class="container py-4">
    <b class="text-left mb-3">Resultado da busca por <?=$_POST['busca']?> no campo <?=$_POST['campo']?></b>
    <div class="info p-4">

        <div class="list-group">
            <?php

echo "COMANDO : ".$Comando;

                echo $query = "select
                                a.*,
                                b.nome as bairro,
                                c.nome as cidade,
                                e.nome as estado,
                                d.descricao as tipo_documento,
                                i.descricao as tipo_imovel
                            from documentos
                                left join aux_bairros b on a.bairro = b.codigo
                                left join aux_cidades c on a.cidade = c.codigo
                                left join aux_estados e on a.estado = e.codigo

                                left join aux_tipo_documento d on a.tipo_documento = d.codigo
                                left join aux_tipo_imovel i on a.tipo_imovel = i.codigo
                            ";
                $result = mysqli_query($con, $query);
                while(mysqli_fetch_object($result)){
            ?>


            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?=$d->rua?>, <?=$d->numero?>, <?=$d->bairro?>, <?=$d->cidade?> - <?=$d->estado?> <?=$d->cep?> </h5>
                <small><?=$d->data_registro?></small>
                </div>
                <?php
                $query1 = "select * from vendedor_comprador where documento_id = '{$d->codigo}' order by tipo desc";
                $result1 = mysqli_query($con, $query1);
                $vc = false;
                while($d1 = mysqli_fetch_object($result1)){
                    if($vc != $d1->tipo){
                        $vc = $d1->tipo;
                ?>
                    <p class="mb-1"><?=(($d1->tipo == 'v')?'Vendedor':'Comprador')?></p>
                <?php
                    }
                ?>
                <small><?=$d1->nome?> - <?=$d1->cpf?></small><br>
                <?php
                }
                ?>
            </a>
            <?php
                }
            ?>
        </div>

    </div>
</div>