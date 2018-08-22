<?php
	try {
 		 $conn = new PDO('mysql:host=127.0.0.1;dbname=base', $username = 'terruel', $password = 'terruel');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
    	echo 'ERROR: ' . $e->getMessage();
	}
	
	$arquivo = file_get_contents('tickets.json');
	$json = json_decode($arquivo);

	foreach($json as $registro){
		echo 'Ticket: '. $registro->TicketID . ' - Nome: ' . $registro->CustomerName . '<br>';
	}	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

</body>
</html>