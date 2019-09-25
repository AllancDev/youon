<?php
ini_set('display_errors',1); ini_set('display_startup_erros',1); error_reporting(E_ALL);
include("scripts/connect.php"); 

setlocale(LC_ALL,'pt_BR.UTF8');
mb_internal_encoding('UTF8'); 
mb_regex_encoding('UTF8');

$tabela = "pedidos_venda"; #Nome da tabela
if(isset($_POST['Ano'])) {$filtro1 = ($_POST['Ano']);} else {$filtro1 = 2019;} #filtra ano
if(isset($_POST['Mes'])) {$filtro2 = ($_POST['Mes']);} else {$filtro2 = 1;} #filtra mes


    $sql = "SELECT id, Data, IdContato, Desconto, Observacoes, Situacao, IdProduto, Descricao, Quantidade, ValorUnitario
    FROM $tabela";

$params = array();
$options =array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$stmt = mysql_query( $conn, $sql, $params, $options);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$numRegistros = mysql_num_rows($stmt);

?>


<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Telefonica - Planejamento Insourcing</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../apple-icon.png">
    <link rel="shortcut icon" href="../favicon.ico">

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    
    <link rel="stylesheet" href="../assets/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>


                
                                            <div class="card">
                                                <div class="card-header">
                                                     <strong data-toggle="collapse" data-target="#filtro">Filtros<small><span class="float-right mt-1"><i class="fa fa-bars"></i></span></small></strong>
                                                    </div>
                                                    <div id="filtro" class="card-body card-block collapse">
                                                        <form action="" method="post" class="form-inline">
                                                            
                                                        <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Ano:</label></div>
                                                                    <div class="col-12 col-md-9">
                                                                        <select name="Ano" id="Ano" class="form-control">
                                                                            <option value="">Selecione</option>    
                                                                            <option value="2019">2019</option>
                                                                            <option value="2018">2018</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                        <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Mês:</label></div>
                                                                    <div class="col-12 col-md-9">
                                                                        <select name="Mes" id="Mes" class="form-control">
                                                                            <option value="">Selecione</option>    
                                                                            <option value="1">Janeiro</option>
                                                                            <option value="2">Fevereiro</option>
                                                                            <option value="3">Março</option>
                                                                            <option value="4">Abril</option>
                                                                            <option value="5">Maio</option>
                                                                            <option value="6">Junho</option>
                                                                            <option value="7">Julho</option>
                                                                            <option value="8">Agosto</option>
                                                                            <option value="9">Setembro</option>
                                                                            <option value="10">Outubro</option>
                                                                            <option value="11">Novembro</option>
                                                                            <option value="12">Dezembro</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i> Filtrar
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-ban"></i> Limpar
                                                        </button>
                                                        </form>
                                                    </div>

                                             </div>
                
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Programa de Remuneração Variável</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" style="width:100%" class="table table-striped table-bordered table-hover row-border order-column pretty">
                                    <thead>
                                    <tr>
                                        <th colspan="3">Id</th>
                                        <th colspan="2">Referência</th>
                                        <th colspan="2">Localidade</th>
                                        <th colspan="5">Informações do Colaborador</th>
                                        <th colspan="5">Produtividade</th>
                                        <th colspan="4">Resultado</th>
                                    </tr>
                                        <tr>
                                            <th>Colaborador</th>
                                            <th>Matricula</th>
                                            <th>Login</th>
                                            <th>Ano</th>
                                            <th>Mês</th>
                                            <th>Regional</th>
                                            <th>Cidade</th>
                                            <th>Data Admissão</th>
                                            <th>Cargo</th>
                                            <th>Supervisor</th>
                                            <th>Status</th>
                                            <th>Dias Trab.</th>
                                            <th>Prod</th>
                                            <th>Atg Prod</th>
                                            <th>Meta Prod</th>
                                            <th>Peso Prod</th>
                                            <th>Peso Final Prod</th>
                                            <th>Atingimento</th>
                                            <th>SB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while( $row = mysql_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) { ?>
                                            <tr>
                                                <td><?php echo $row['COLABORADOR'] ?></td>
                                                <td><?php echo $row['MATRICULA'] ?></td>
                                                <td><?php echo $row['LOGIN'] ?></td>
                                                <td><?php echo $row['Ano'] ?></td>
                                                <td><?php echo $row['Mes'] ?></td>
                                                <td><?php echo $row['REGIONAL'] ?></td>
                                                <td><?php echo utf8_encode($row['CIDADE']) ?></td>
                                                <td><?php echo date_format($row['DATAADMISSAO'],'Y/m/d') ?></td>
                                                <td><?php echo $row['CARGO'] ?></td>
                                                <td><?php echo $row['SUPERVISOR'] ?></td>
                                                <td><?php echo utf8_encode ($row['STATUS']) ?></td>
                                                <td><?php echo $row['DIASTRABALHADOS'] ?></td>
                                                <td><?php echo str_replace(".",",",round($row['PROD'],2)) ?></td>
                                                <td><?php echo str_replace(".",",",round($row['ATG_PROD'],4)*100)."%" ?></td>
                                                <td><?php echo $row['META_PROD'] ?></td>
                                                <td><?php echo $row['PESO_PROD'] ?></td>
                                                <td><?php echo str_replace(".",",",round($row['PESO_FINAL_PROD'],2)) ?></td>
                                                <td><?php echo str_replace(".",",",round($row['ATINGIMENTO_FINAL'],4)*100)."%" ?></td>
                                                <td><?php echo str_replace(".",",",$row['SB_FINAL']*100)."%" ?></td>
                                            </tr>
                                            <?php } ?>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                            

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="../assets/js/init-scripts/data-table/datatables-init.js"></script>
    <script src="../assets/js/dataTables.fixedColumns.min.js"></script>
    
</body>

</html>
