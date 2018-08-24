<?php

	$arquivo = file_get_contents('tickets.json');
	$json = json_decode($arquivo, true);

	$array = [];

	foreach($json as $registro){
		//echo "<pre>";
		//print_r($registro['Interactions'][0]['Message']);
		foreach($registro['Interactions'] as $interaction){
			//echo "<pre>";
			//print_r($msg['Message']);
			$tokenizer = explode(' ', $interaction['Message']);
			//echo "<pre>";
			//print_r($tokenizer);
			//die;

			foreach($tokenizer as $word){
				$word = str_replace('.', '', $word);
			}
			echo "<pre>";
			print_r($tokenizer);
			die;
			$msg_nova = str_replace('.', '', $tokenizer);
			$msg_nova .= str_replace(',', '', $tokenizer);
			$msg_nova .= str_replace('?', '', $tokenizer);
			$msg_nova .= str_replace('!', '', $tokenizer);
			$msg_nova .= str_replace(':', '', $tokenizer);
			$msg_nova .= str_replace('/', '', $tokenizer);
			
			$array[$registro['TicketID']][$interaction['DateCreate']] = $msg_nova;			
		}
		
	}
	echo "<pre>";
	print_r($array);
	
?>

