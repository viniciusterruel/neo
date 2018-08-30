<?php

	$json_prio  = [];
	$json_api   = [];
	$data_de    = '0000-00-00';
	$ordenar    = 'prioridade';
	$prioridade = 'Alta';

	session_start("envia_json");
	$json_api = $_SESSION ['dados'];
	
	$ordenar    = $_POST['ordenar'];
	$data_de    = $_POST['datade'];
	$data_ate   = $_POST['dataate'];
	$prioridade = $_POST['prioridade'];

	if(empty($data_ate)){
		$data_ate = '9999-99-99';
	}

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
	//echo "<pre>";
	//print_r($json_prio);

	if($ordenar == 'criacao'){
		uasort($json_prio, function($a, $b){
    		return $a['DateCreate'] > $b['DateCreate'];
		});
		echo "<pre>";
		print_r($json_prio);
	}
	elseif($ordenar == 'atualizacao'){
		uasort($json_prio, function($a, $b){
    		return $a['DateUpdate'] > $b['DateUpdate'];
		});
		echo "<pre>";
		print_r($json_prio);
	}
	elseif($ordenar == 'prio'){
		uasort($json_prio, function($a, $b){
    		return $a['0'] < $b['0'];
		});
		echo "<pre>";
		print_r($json_prio);
	}

?>