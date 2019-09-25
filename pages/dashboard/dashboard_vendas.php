<?php

include("../../scripts/conn.php"); 

setlocale(LC_ALL,'pt_BR.UTF8');
mb_internal_encoding('UTF8'); 
mb_regex_encoding('UTF8');

$tabela = "pedidos_venda"; #Nome da tabela
$Anomes = "092019";
$meta_mes = 20000; 
$meta_dia = 650;

    $sqldate = "SELECT max(data) as Data FROM youon.pedidos_venda
       Where Situacao = 'Atendido'
        and CONCAT(date_format(data,'%m'),YEAR(data)) = (SELECT max(CONCAT(date_format(data,'%m'),YEAR(data))) FROM youon.pedidos_venda);";
    $resultdate = $conn->query($sqldate);

    $sqlb1 = "SELECT SUM(Qtd) as Qtd, SUM(ValorTotal) as Valor FROM (        
        SELECT id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido'
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t; ";
    $resultb1 = $conn->query($sqlb1);
    
    $sqlb2 = "SELECT AVG(Valor) as Valor From (
        SELECT data, SUM(Qtd) as Qtd, SUM(ValorTotal) as Valor FROM (        
        SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido' and DAYOFWEEK(data) not in (1,7) #and id = 6262714687
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t group by data) t;";
    $resultb2 = $conn->query($sqlb2);

    $sqlb3 = "SELECT AVG(Valor) as Valor From (
        SELECT data, SUM(Qtd) as Qtd, SUM(ValorTotal) as Valor FROM (        
        SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido' and DAYOFWEEK(data) = 7 #and id = 6262714687
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t group by data) t;";
    $resultb3 = $conn->query($sqlb3);

    $sqlb4 = "SELECT AVG(Valor) as Valor From (
        SELECT data, SUM(Qtd) as Qtd, SUM(ValorTotal) as Valor FROM (        
        SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido' and DAYOFWEEK(data) = 1 #and id = 6262714687
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t group by data) t;";
    $resultb4 = $conn->query($sqlb4);

    $sqlb5 = "SELECT count(id) Qtd, SUM(Quantidade*(ValorUnitario-Desconto)) as Valor, sum(valorunitario)/count(id) Ticket,
    (SUM(pv.ValorUnitario)/SUM(se.PrecoCusto)-1)*100 as Margem 
    FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
    ON pv.idproduto = se.idproduto        
    Where Situacao = 'Atendido'
    and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes;";
    $resultb5 = $conn->query($sqlb5);

    $sqlb6 = "SELECT data, SUM(Qtd) as Qtd, SUM(ValorTotal) as ValorTotal FROM (      
        SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido' and DAYOFWEEK(data) <> 1
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t group by data order by SUM(ValorTotal) desc LIMIT 1;";
    $resultb6 = $conn->query($sqlb6);

    $sqlb7 = "SELECT data, SUM(Qtd) as Qtd, SUM(ValorTotal) as ValorTotal FROM (      
        SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido' and DAYOFWEEK(data) <> 1
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
            Group by id) t group by data order by SUM(ValorTotal) LIMIT 1;";
    $resultb7 = $conn->query($sqlb7);

    $sqlb8 = "SELECT SUM(ValorTotal) as Valor FROM (        
        SELECT id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido'
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
                and DAY(data) <= 15
            Group by id) t;";
    $resultb8 = $conn->query($sqlb8);    

    $sqlb9 = "SELECT SUM(ValorTotal) as Valor FROM (        
        SELECT id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
                SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
        FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
        ON pv.idproduto = se.idproduto        
                Where Situacao = 'Atendido'
                and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
                and DAY(data) > 15
            Group by id) t;";
    $resultb9 = $conn->query($sqlb9);   
    
    //Verificar dias acima da meta
    $sqlb10 = "SELECT  SUM(ATINGIU) AS ATINGIU, COUNT(ATINGIU) TOTAL FROM (
        SELECT SUM(Valor) as  Valor, 
                CASE
                    WHEN SUM(Valor) >= $meta_dia THEN 1
                    ELSE 0
                END AS ATINGIU
         FROM (     
            SELECT  data, (SUM(ValorUnitario)-SUM(desconto)/count(id)) Valor
            FROM youon.pedidos_venda pv      
                    Where Situacao = 'Atendido' and DAYOFWEEK(data) <> 1
                    and CONCAT(date_format(data,'%m'),YEAR(data)) = $Anomes
                Group by id) t group by data) t2;";
    $resultb10 = $conn->query($sqlb10);  
      
    //informações para datatable
    $sql = "SELECT se.CodigoProduto as Codigo, pv.Descricao, sum(pv.quantidade) Quantidade, se.PrecoCusto as Custo,
    pv.ValorUnitario as ValorUnitario, sum(pv.ValorUnitario) Valor,
      ((pv.ValorUnitario/se.PrecoCusto)-1)*100 as Margem, se.balanco as estoque,
      CASE
      WHEN ceiling(cob.media) is null then 0
      ELSE ceiling(cob.media)
      END as media3,
      CASE
      WHEN floor(cob.cobertura) is null then 0 
      ELSE floor(cob.cobertura)
      END as cobertura
      FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
      ON pv.idproduto = se.idproduto
      LEFT JOIN (
      SELECT se.CodigoProduto as Codigo, (sum(pv.quantidade)/3) as media, se.balanco/(sum(pv.quantidade)/90) as cobertura
      FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
      ON pv.idproduto = se.idproduto
      Where CONCAT(date_format(pv.data,'%m'),YEAR(data)) between 062019 and 082019
      and pv.Situacao = 'Atendido'
      group by se.CodigoProduto
      ) cob ON cob.codigo = se.CodigoProduto
      Where CONCAT(date_format(pv.data,'%m'),YEAR(data)) = 092019
      and pv.Situacao = 'Atendido'
      group by pv.Descricao
      order by sum(pv.quantidade) desc;";
    $result = $conn->query($sql);
    
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>You.On | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">

    <?php include("../parts/menu.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">   
      <h1>
        Dashboard
        <?php while($row = $resultdate->fetch_assoc()) { ?>
            <small>Atualizado até <?php echo date("d/m/Y", strtotime($row['Data'])) ?></small>
        <?php }?>            
      </h1>    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">

          <div class="row">
              <!-- Date and time range -->
            <div class="col-lg-3 col-xs-6">
              <div class="form-group">
                <label>Período:</label>
                <div class="input-group">
                  <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                      <i class="fa fa-calendar"></i> Selecione a data 
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
            </div>
              <!-- /.form group -->
          </div>
              <!-- /.form group -->

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            <?php while($row = $resultb1->fetch_assoc()) { ?>
              <h3><sup style="font-size: 20px">R$ </sup><?php $tv = $row['Valor']; echo number_format($tv,2,',','.'); ?></h3>
            <?php }?>
              <p>Total Vendas Mês</p>
            </div>
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <?php while($row = $resultb2->fetch_assoc()) { ?>
              <h3><sup style="font-size: 20px">R$ </sup><?php echo number_format($row['Valor'],2,',','.') ?></h3>
            <?php }?>

              <p>Média Dias Úteis</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
            <?php while($row = $resultb3->fetch_assoc()) { ?>
              <h3><sup style="font-size: 20px">R$ </sup><?php echo number_format($row['Valor'],2,',','.') ?></h3>
            <?php }?>
              <p>Média Sábados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <?php while($row = $resultb4->fetch_assoc()) { ?>
              <h3><sup style="font-size: 20px">R$ </sup><?php echo number_format($row['Valor'],2,',','.') ?></h3>
            <?php }?>

              <p>Média Domingos</p>
            </div>
            <div class="icon">
              <i class="fa fa-sun-o"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Relatório Diário de Vendas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
            <!--<p class="text-center">
                    <strong>Vendas: 1 Jan, 2019 - 30 Jul, 2019</strong>
                  </p>-->
                  <div class="chart"> 
                    <!-- Sales Chart Canvas -->
                    <canvas id="vendasdia" height="100"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Atingimento da Meta</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">Meta do Mês</span>
                    <span class="progress-number"><b><?php $percvend = ($tv / $meta_mes)*100 ; echo 'R$ ' . number_format($tv,2,',','.') ?></b><?php echo '/R$'.number_format($meta_mes,2,',','.');?></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($percvend,2,',','.') .'%' ?>" style="<?php echo 'width: ' . $percvend .'%' ?>"><span data-tooltip="<?php echo 'width: ' . $percvend .'%' ?>"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Dias Úteis Acima da Meta</span>
                    <?php while($row = $resultb10->fetch_assoc()) { ?>
                        <span class="progress-number"><b><?php $percdia = ($row['ATINGIU'] / $row['TOTAL'])*100; echo $row['ATINGIU'] ?></b><?php echo '/' . $row['TOTAL'] ?></span>
                    <?php }?>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($percdia,2,',','.') .'%' ?>" style="<?php echo 'width: ' . $percdia .'%' ?>"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="progress-number"><b>480</b>/800</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Send Inquiries</span>
                    <span class="progress-number"><b>250</b>/500</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 10%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-2 col-xs-3">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <?php while($row = $resultb5->fetch_assoc()) { ?>
                        <h5 class="description-header"><?php echo number_format($row['Margem'],2,',','.') ?>%</h5>
                    <span class="description-text">MARGEM</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-3">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">R$<?php echo number_format($row['Ticket'],2,',','.') ?></h5>
                    <?php } ?> 
                    <span class="description-text">TICKET MÉDIO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-3">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <?php while($row = $resultb8->fetch_assoc()) { ?>
                        <h5 class="description-header">R$<?php echo number_format($row['Valor'],2,',','.') ?></h5>
                    <?php } ?> 
                    <span class="description-text">QUINZENA 1</span>
                  </div>
                  <!-- /.description-block -->
                </div>   
                <!-- /.col -->
                <div class="col-sm-2 col-xs-3">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <?php while($row = $resultb9->fetch_assoc()) { ?>
                        <h5 class="description-header">R$<?php echo number_format($row['Valor'],2,',','.') ?></h5>
                    <?php } ?> 
                    <span class="description-text">QUINZENA 2</span>
                  </div>
                  <!-- /.description-block -->
                </div>                                
                <!-- /.col -->
                <div class="col-sm-2 col-xs-3">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <?php while($row = $resultb6->fetch_assoc()) { ?>
                    <h5 class="description-header">R$<?php echo number_format($row['ValorTotal'],2,',','.') ?></h5>
                    <?php } ?> 
                    <span class="description-text">MELHOR DIA</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <?php while($row = $resultb7->fetch_assoc()) { ?>
                    <h5 class="description-header">R$<?php echo number_format($row['ValorTotal'],2,',','.') ?></h5>
                    <?php } ?> 
                    <span class="description-text">PIOR DIA</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Produtos Vendidos no Mês</h3>

                        <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                          </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                        <div class="box-body">  
                            <table id="example2" class="table table-bordered table-striped  table-hover">
                            <thead>
                                <tr>
                                    <th>Cod</th>
                                    <th>Descrição</th>
                                    <th>Qtd</th>
                                    <th>Custo</th>
                                    <th>Venda</th>
                                    <th>Valor Total</th>
                                    <th>Margem</th>
                                    <th>Estoque</th>
                                    <th>Qtd 3 meses</th>
                                    <th>Cobertura</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['Codigo'] ?></td>    
                                    <td><?php echo $row['Descricao'] ?></td>
                                    <td><?php echo $row['Quantidade'] ?></td>
                                    <td><?php echo 'R$ ' . number_format($row['Custo'],2,',','.') ?></td>
                                    <td><?php echo 'R$ ' . number_format($row['ValorUnitario'],2,',','.') ?></td>
                                    <td><?php echo 'R$ ' . number_format($row['Valor'],2,',','.') ?></td>
                                    <td><?php echo number_format($row['Margem'],2,',','.').'%' ?></td>
                                    <td><?php echo $row['estoque'] ?></td>
                                    <td><?php echo $row['media3'] ?></td>
                                    <td><?php echo $row['cobertura'].' dias' ?></td>
                                </tr>
                            <?php } ?>   
                            </tbody>            
                            </table>
                        </div>
                </div>
            </div>

    </section>

    <?php include("../parts/footer.php"); ?>
    
</div>
  <!-- /.content-wrapper -->
<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Sparkline -->
<script src="../../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hoje'       : [moment(), moment()],
          'Ontem'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 dias' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
          'Este mês'  : [moment().startOf('month'), moment().endOf('month')],
          'Último mês'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
  })
</script>
<!-- Gráficos -->
<script type="text/javascript" src="js/Chart.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
</body>
</html>