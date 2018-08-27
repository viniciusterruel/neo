<!DOCTYPE html>
<html>
<head>
	 <link rel="stylesheet" href="css/bootstrap.css">
	<title>Teste</title>
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
	//echo "<pre>";
	//print_r($valor_msg);
?>


<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Example select</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Example multiple select</label>
    <select multiple class="form-control" id="exampleFormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
</form>


</body>
</html>