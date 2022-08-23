<?php
include_once "../config/includes.php";


switch($_POST['campo']){

    case 'aleatorio':{
        $busca = explode(',', $_POST['busca']);
        $w = [
                    'a.rua',
                    'a.cep',
                    'b.nome',
                    'c.nome',
                    'e.nome',
                    'v.nome',
                    'v.rg',
                    'v.cpf',
                    'v.cnpj'
                ];
        $where = [];
        for($i=0;$i<count($busca);$i++){
            for($j = 0;$j<count($w); $j++){
                $where[] = "{$w[$j]} like '%{$busca[$i]}%'";
            }
        }
        $where = implode(" or ", $where);
        break;
    }
    case 'comprador_nome':{
        $where = "v.tipo = 'c' and v.nome LIKE '%{$_POST['busca']}%'";
        break;
    }
    case 'comprador_cpf':{
        $busca = str_replace(array('-','.'), false, $_POST['busca']);
        $where = "v.tipo = 'c' and (v.cpf = '{$busca}' or v.cpf = '{$_POST['busca']}')";
        break;
    }
    case 'comprador_razao_social':{
        $where = "v.tipo = 'c' and v.nome LIKE '%{$_POST['busca']}%'";
        break;
    }
    case 'comprador_cnpj':{
        $busca = str_replace(array('-','.','/'), false,$_POST['busca']);
        $where = "v.tipo = 'c' and (v.cnpj = '{$_POST['busca']}' or v.cnpj = '{$busca}')";
        break;
    }
    case 'vendedor_nome':{
        $where = "v.tipo = 'v' and v.nome LIKE '%{$_POST['busca']}%'";
        break;
    }
    case 'vendedor_cpf':{
        $busca = str_replace(array('-','.'), false, $_POST['busca']);
        $where = "v.tipo = 'v' and (v.cpf = '{$busca}' or v.cpf = '{$_POST['busca']}')";
        break;
    }
    case 'vendedor_razao_social':{
        $where = "v.tipo = 'v' and v.nome LIKE '%{$_POST['busca']}%'";
        break;
    }
    case 'vendedor_cnpj':{
        $busca = str_replace(array('-','.','/'), false,$_POST['busca']);
        $where = "v.tipo = 'v' and (v.cnpj = '{$_POST['busca']}' or v.cnpj = '{$busca}')";
        break;
    }
    case 'endereco':{
        $busca = explode(',', $_POST['busca']);
        $w = [
                    'a.rua',
                    'a.cep',
                    'b.nome',
                    'c.nome',
                    'e.nome'
                ];
        $where = [];
        for($i=0;$i<count($busca);$i++){
            for($j = 0;$j<count($w); $j++){
                $where[] = "{$w[$j]} like '%{$busca[$i]}%'";
            }
        }
        $where = implode(" or ", $where);
        break;
    }
    default:{
        exit();
    }
};
$where = (($where)?" and ({$where})":false);

?>
<div class="container py-4">
    <b class="text-left mb-3">Resultado da busca por <?=$_POST['busca']?> no campo <?=$_POST['campo']?></b>
    <div class="info p-4">

        <div class="list-group">
            <?php

                echo $query = "select
                                a.*,
                                b.nome as bairro,
                                c.nome as cidade,
                                e.nome as estado,
                                d.descricao as tipo_documento,
                                i.descricao as tipo_imovel
                            from documentos a
                                left join aux_bairros b on a.bairro = b.codigo
                                left join aux_cidades c on a.cidade = c.codigo
                                left join aux_estados e on a.estado = e.codigo

                                left join aux_tipo_documento d on a.tipo_documento = d.codigo
                                left join aux_tipo_imovel i on a.tipo_imovel = i.codigo

                                left join vendedor_comprador v on a.codigo = v.documento_id

                            where 1 {$where}";
                $result = mysqli_query($con, $query);
                while($d = mysqli_fetch_object($result)){
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