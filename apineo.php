<?php

	$json_prio = [];
	$json_api = [];

	session_start("envia_json");
	$json_api = $_SESSION ['dados'];
	
	$ordenar = $_POST['ordenar'];
	$data_de = $_POST['datade'];
	$data_ate = $_POST['dataate'];
	$prioridade = $_POST['prioridade'];



	if($prioridade == 'Alta'){
		foreach($json_api as $tick){
			if(($tick['1'] == $prioridade) && ($tick['DateCreate'] >= $data_de) && $tick['DateCreate'] <= $data_ate){
				array_push($json_prio, $tick);
			}
		}
	}
	elseif($prioridade == 'Normal'){
		foreach($json_api as $tick){
			if(($tick['1'] == $prioridade) && ($tick['DateCreate'] >= $data_de) && $tick['DateCreate'] <= $data_ate){
				array_push($json_prio, $tick);
			}
		}
	}
	json_encode($json_prio);
	echo "<pre>";
	print_r($json_prio);

?>