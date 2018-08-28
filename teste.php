
<!DOCTYPE html>
<html>
<head> 
	 <link rel="stylesheet" type="text/css" href="style.css">
	<title>Desafio NeoAssist</title>
</head>
<body>

<?php
//Criação dos dicionários de categorias para comparação futura com as mensagens-------------------------------------------------------
	$elogio = array("obrigado", "obrigada", "agradecer", "agradecemos", "gentileza", "gentil", "gentis", "satisfação", "satisfeito", "satisfeita", "ótimo", "bom", "gostar", "gostei", "gostando", "gostamos", "parabéns");
	$duvida = array("procurar", "procurando", "conseguir", "consigo", "conseguindo", "querer", "quero", "queria", "saber", "saberia", "parcelar", "parcela", "parcelas", "renovar", "renovada", "renovação", "acessar", "acesso", "fazer", "cadastrar", "cadastro", "cadastrei", "rastrear", "rastramento", "rastreio");
	$atencao = array("comprar", "comprei", "aguardar", "aguardo", "trocar", "troquei", "trocamos", "querer", "quero", "cancelar", "cancelamento", "fazer", "funcionar", "funciona", "funcionando", "resolver");
	$atraso = array("comprar", "comprei", "aguardar", "aguardo", "entregar", "entrega", "entregue", "atrasar", "atrasado", "atrasada", "atraso", "dias", "dia", "prazo", "chegar", "chegou", "acontecer", "aconteceu");
	$insatisfacao = array("comprar", "comprei", "aguardar", "aguardo", "solucionar", "solução", "atrasar", "atraso", "atrasada", "atrasado", "providenciar", "providências", "reclamar", "reclamação", "procon", "reclameaqui", "querer", "quero", "cancelar", "cancelamento");
	$total = "";
//-----------------------------------------------------------------
	$arquivo = file_get_contents('tickets.json'); //Lê o arquivo json
	$json = json_decode($arquivo, true); //Decodifica o json e coloca no vetor $json
//-----------------------------------------------------------------
	$tokenizer = []; //Vetor para guardar a mensagem tokenizada
	$mensagens = []; //Vetor para guardar os vetores das mensagens tokenizadas
	$valor_msg = []; //vetor com a pontuação de cada mensagem
//Operações realizadas para a obtenção do vetor de vetores das primeiras mensagens de cada ticket---------------------------------
	foreach($json as $ticket){ //percorre o "cabeçalho dos tickets"
		foreach($ticket['Interactions'] as $interaction){ //percorre as interações do ticket
		//Retira as pontuações da mensagem-------------------------
			$nocarac = str_replace('.', '', $interaction['Message']);
			$nocarac = str_replace(',', '', $nocarac);
			$nocarac = str_replace('?', '', $nocarac);
			$nocarac = str_replace('!', '', $nocarac);
			$nocarac = str_replace(':', '', $nocarac);
			$nocarac = str_replace('/', '', $nocarac);
		//--------------------------------------------------------
		
			$alllower = mb_strtolower($nocarac);//Deixa a string totalmente minúscula e com os acentos 	
			$tokenizer = explode(' ', $alllower);//Separa a mensagem em palavras e coloca no vetor tokenizer
			$mensagens[$ticket['TicketID']] = $tokenizer; //Guarda o vetor tokenizer no vetor de vetores $mensagens
			
			break; //Para o foreach para pegar somente a primeira mensagem de cada ticket
		}
		
		$novo = array_intersect($mensagens[$ticket['TicketID']], $elogio); //compara o que é igual nos vetores
		$vt_elogio = $novo; //coloca em um novo vetor
		$cont_pal_elogio = [sizeof($vt_elogio) * -2]; //conta quantas palavras da categoria elogio existem no vetor e multiplica pelo valor
		$novo = array_intersect($mensagens[$ticket['TicketID']], $duvida);//compara o que é igual nos vetores
		$vt_duvida = $novo;//coloca em um novo vetor
		$cont_pal_duvida = [sizeof($vt_duvida) * 0];//conta quantas palavras da categoria elogio existem no vetor e multiplica pelo valor
		
		$novo = array_intersect($mensagens[$ticket['TicketID']], $atencao);//compara o que é igual nos vetores
		$vt_atencao = $novo;//coloca em um novo vetor
		$cont_pal_atencao = [sizeof($vt_atencao) * 2];//conta quantas palavras da categoria elogio existem no vetor e multiplica pelo valor
		$novo = array_intersect($mensagens[$ticket['TicketID']], $atraso);//compara o que é igual nos vetores
		$vt_atraso = $novo;//coloca em um novo vetor
		$cont_pal_atraso = [sizeof($vt_atraso) * 4];//conta quantas palavras da categoria elogio existem no vetor e multiplica pelo valor
		$novo = array_intersect($mensagens[$ticket['TicketID']], $insatisfacao);//compara o que é igual nos vetores
		$vt_insatisfacao = $novo;//coloca em um novo vetor
		$cont_pal_insatisfacao = [sizeof($vt_insatisfacao) * 6];//conta quantas palavras da categoria elogio existem no vetor e multiplica pelo valor
		$total = array_merge($vt_duvida, $vt_atencao, $vt_atraso, $vt_insatisfacao);//junta todos os vetores em um só
		$total_cont = array_merge($cont_pal_elogio, $cont_pal_duvida, $cont_pal_atencao, $cont_pal_atraso, $cont_pal_insatisfacao); //junta as pontuaçõe em um vetor só
		$valor = [array_sum($total_cont)]; //soma os valores do um vetor
		$valor_msg = array_merge($valor_msg, $valor); //coloca a soma em um vetor 
		//echo "<pre>";
		//print_r($valor_msg);
		
	}
	$i = 0;//inicializa uma variável auxiliar
	$novo_json = $json;//coloca o json inicial em um outro json
	$alta = ["Prioridade"=>"Alta"];
	$normal = ["Prioridade"=>"Normal"];
	//percorre os tickets do json----------------------------------------
	foreach($novo_json as $pedaco){
		if($valor_msg[$i] >= 4){
			array_push($pedaco, $valor_msg[$i]);//adiciona um novo campo ao json em cada ticket
			array_push($pedaco, $alta['Prioridade']);
			array_push($novo_json, $pedaco);//adiciona o novo ticket ao json
		}
		elseif($valor_msg[$i] < 4){
			array_push($pedaco, $valor_msg[$i]);//adiciona um novo campo ao json em cada ticket
			array_push($pedaco, $normal['Prioridade']);
			array_push($novo_json, $pedaco);//adiciona o novo ticket ao json
		}
		$i++;//itera a variável auxilial
	}
	//-------------------------------------------------------------------
	json_encode($novo_json);//guarda o novo json
	$divide_array = sizeof($novo_json)/2;//Divide o tamanho do novo json ao meio
	//Como o novo json tem agora duas partes: uma com todos os tickets sem o novo campo (pontuação), e outro com o novo campo, queremos tirar a primeira parte, e deixar somente os tickets com as pontuações--------------------------------------------------------------
	for($x=0; $x<=$divide_array-1; $x++){
		array_shift($novo_json);
	}
	//--------------------------------------------------------------------------
	json_encode($novo_json);//decodifica novamente o json agora totalmente correto
	//echo "<pre>";
	//print_r($novo_json);
	
?>



 <h1 class="register-title">Desafio NeoAssist</h1>
  <form class="register" action="apineo.php" method="post">
    <select class="basic simple" name="ordenar">
    	<option value="">Ordenar por</option>
    	<option value="criacao">Ordem de criação</option>
    	<option value="atualizacao">Ordem de atualização</option>
    	<option value="prio">Prioridade</option>
    </select>
    <p><label class="label-data">Data de Criação:</label></p>
    <input type="date" name="datade" class="register-input" placeholder="Data De">
    <p><label class="label-data">Até:</label></p>
    <input type="date" name="dataate" class="register-input" placeholder="Data Até">
 	<p><label class="label-data">Prioridade: </label></p>
 	<p id="p-radio">
	<input type="radio" name="prioridade" value="Alta" checked="checked">Alta
	<input type="radio" name="prioridade" value="Normal">Normal
	</p>
    <input type="submit" value="Enviar" class="register-button">
</form>




</body>
</html>