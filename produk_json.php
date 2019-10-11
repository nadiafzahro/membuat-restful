<?php
$servername = "localhost";
$username = "root";
$passwd = "";
$database = "northwind";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$database",$username,$passwd);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
}catch(PDOException $e){
	echo "Connection failed : ".$e->getMessage();
}

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
$name = isset($_GET['name']) ? $_GET['name'] : '';

$sql_limit = '';
if(!empty($limit)) {
	$sql_limit = 'LIMIT 0,'.$limit;
}

$sql_name = '';
if(!empty($name)){
	$sql_name = ' WHERE p.ProductName LIKE \'&'.$name.'%\' ';
}

$sql = "SELECT * FROM products AS p JOIN categories AS C
		ON p.CategoryID=c.CategoryID ".$sql_name;
		
$data = $conn->prepare($sql);
$data->execute();
$products = [];
while($row = $data->fetch(PDO::FETCH_OBJ)){
	$products[] = ["ProductID"=>$row->ProductID,
				   "ProductName"=>$row->ProductName,
				   "CategoryName"=>$row->CategoryName,
				   "UnitPrice"=>$row->UnitPrice,
				   "UnitsInStock"=>$row->UnitsInStock];	
}

$conn = null;
header('Content-Type: application/json');

$arr = array();
$arr['info'] = 'success';
$arr['num'] = count($products);
$arr['result'] = $products;

echo json_encode(array('ITEMS'=>$arr),
JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

?>