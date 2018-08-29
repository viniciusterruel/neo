<?php
	echo "<pre>";
	print_r($_POST);
	echo "<br>";
	echo ($_POST['ordenar']);
	echo "<br>";
	echo ($_POST['datade']);
	echo "<br>";
	echo ($_POST['dataate']);
	echo "<br>";
	echo ($_POST['prioridade']);
	echo "<pre>";
	
	$jsonRet = json_decode(curl_exec($ch));
	echo "<pre>";
	print_r($jsonRet);
	


	$ordenar = $_POST['ordenar'];
	$data_de = $_POST['datade'];
	$data_ate = $_POST['dataate'];
	$prioridade = $_POST['prioridade'];
?>

