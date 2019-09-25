<?php
//setting header to json
header('Content-Type: application/json');

include("../../scripts/conn.php"); 

//query to get data from the table
$query = "SELECT CONCAT(LEFT(DAYNAME(data),3),'-',DAY(data)) as dia, round(SUM(ValorTotal),2) as valor, 650 as meta FROM (        
	SELECT data, id, count(id) qtd, SUM(desconto)/count(id) desconto, sum(quantidade) quantidade,
			SUM(ValorUnitario)-SUM(desconto)/count(id) ValorTotal, SUM(PrecoCusto) PrecoCusto
	FROM youon.pedidos_venda pv LEFT JOIN saldos_estoque se
	ON pv.idproduto = se.idproduto        
			Where Situacao = 'Atendido'
			and CONCAT(date_format(data,'%m'),YEAR(data)) = (SELECT max(CONCAT(date_format(data,'%m'),YEAR(data))) FROM youon.pedidos_venda)
		Group by id) t group by data;";

//execute query
$result = $conn->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//now print the data
print json_encode($data);