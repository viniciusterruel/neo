<?php
	$json_prio  = [];//declara o array para receber o json de prioridades
	$json_api   = [];//declara o array para receber o json da página teste.php
	$data_de    = '0000-00-00';//inicializa a data inicial

	session_start("envia_json");//inicia a sessão para receber o json
	$json_api = $_SESSION ['dados'];//recebe o json
	
	$ordenar    = $_POST['ordenar'];//recebe o tipo de ordenaçãp
	$data_de    = $_POST['datade'];//recebe a data mínima
	$data_ate   = $_POST['dataate'];//recebe a data máxima
	$prioridade = $_POST['prioridade'];//recebe a prioridade desejada

	if(empty($data_ate)){
		$data_ate = '9999-99-99';//verifica se a data máxima está vazia, se sim, inicializa com uma data máxima
	}
	if(empty($ordenar)){
		$ordenar = 'prio';//verifica se o tipo de ordenação está vazio, se sim, inicializa com a ordenação por prioridade
	}

	//se a prioridade desejada for alta, para cada ticket verifica se a prioridade é igual, e se a data do ticket está entre o intervalo desejado. Se tudo for satisfeito, adiciona o ticket em um novo json
	if($prioridade == 'Alta'){
		foreach($json_api as $tick){
			if(($tick['1'] == $prioridade) && ($tick['DateCreate'] >= $data_de) && ($tick['DateCreate'] <= $data_ate)){
				array_push($json_prio, $tick);
			}
		}
	}
	//se a prioridade desejada for normal, para cada ticket verifica se a prioridade é igual, e se a data do ticket está entre o intervalo desejado. Se tudo for satisfeito, adiciona o ticket em um novo json
	elseif($prioridade == 'Normal'){
		foreach($json_api as $tick){
			if(($tick['1'] == $prioridade) && ($tick['DateCreate'] >= $data_de) && ($tick['DateCreate'] <= $data_ate)){
				array_push($json_prio, $tick);
			}
		}
	}
	//se a prioridade desejada for todos, para cada ticket verifica se a data do ticket está entre o intervalo desejado. Se tudo for satisfeito, adiciona o ticket em um novo json
	elseif($prioridade == 'Todos'){
		foreach($json_api as $tick){
			if($tick['DateCreate'] >= $data_de && $tick['DateCreate'] <= $data_ate){
				array_push($json_prio, $tick);
			}
		}
	}
	json_encode($json_prio);//codifica o novo json 

	echo "JSon gerado a partir dos seguintes filtros e ordenação: <br>";
	echo "<pre>";
	print_r($_POST);
	echo "<br>";
	echo "-------------------------------------------------";

	//se o tipo de ordenação for por data de criação, ordena o vetor e mostra na tela
	if($ordenar == 'criacao'){
		uasort($json_prio, function($a, $b){
    		return $a['DateCreate'] > $b['DateCreate'];
		});
		echo "<pre>";
		print_r($json_prio);
	}
	//se o tipo de ordenação for por data de atualização, ordena o vetor e mostra na tela
	elseif($ordenar == 'atualizacao'){
		uasort($json_prio, function($a, $b){
    		return $a['DateUpdate'] > $b['DateUpdate'];
		});
		echo "<pre>";
		print_r($json_prio);
	}
	//se o tipo de ordenação for por prioridade, ordena o vetor e mostra na tela
	elseif($ordenar == 'prio'){
		uasort($json_prio, function($a, $b){
    		return $a['0'] < $b['0'];
		});
		echo "<pre>";
		print_r($json_prio);
	}
?>