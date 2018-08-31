# neo
Desafio Neo 
Projeto desenvolvido para o processo seletivo da empresa NeoAssist.

Documentos:
  -pontuacao.php: código que realiza a pontuação e priorização dos tickets.
  -apineo.php: código que realiza a ordenação dos tickets.
  -style.css: código com o estilo da página 'pontuação.php'.
  
pontuacao.php:
  A lógica básica realizada para a pontuação e priorização dos tickets é a seguinte: decodificar o json recebido, retirar todos os
  caracteres que poderiam atrapalhar na comparação entre palavras, e separar a mensagem de um ticket em um vetor contendo uma palavra em
  cada elemento, e aqui cabe uma observação: foram escolhidas para o algoritmo somente a primeira mensagem enviada de cada ticket, pelo
  motivo de que pela primeira mensagem, já podemos caracterizar qual o humor do consumidor e com qual prioridade devemos tratá-lo. 
  Após isso, palavras-chave foram definidas em cinco categorias em forma de vetores, para identificar o assunto e humor do consumidor em
  cada ticket, comparando as palavras das mensagens com as palavras dos cinco vetores.
  Aqui cabe outra observação: para cada categoria, havia uma pontuação (elogios - -2, dúvidas - 0, atenção - 2, atraso - 4 e insatisfação -
  6), e cada vez que palavras parecidas eram encontradas, somava-se o valor da categorias a um contador. 
  Com as pontuações definidas, e guardadas em um vetor, surge outra definição: através de observação, percebeu-se que tickets que
  ultrapassavam 4 pontos, poderiam ser considerados com prioridade alta, e menores que 4, prioridade normal.
  Então, foram adicionados mais dois campos em cada ticket do json, a pontuação e a prioridade. Após isso, o json é enviado para a API.
  Além disso, nesse código há também o formulário html que é enviado para a API para receber os filtros e o tipo de ordenação.
  
apineo.php:
  Nesse código, que é uma representação de uma API, é onde recebemos as variáveis de filtro e ordenação, além do json já com os campos
  prioridade e pontuação.
  Nele, verificamos qual é a prioridade desejada para mostrar os tickets do json (alta, normal, ou se deseja ver todos os tickets), assim
  como qual o intervalo da data de criação desejado, e criamos um novo json com esses filtros.
  Após isso, verificamos qual a ordenação desejada (sendo que se não for selecionada nenhuma, a padrão é por prioridade), e ordenamos o
  json e, por fim, mostramos o json final na tela.
  
  
  **Gostaria de deixar aqui registrado o meu grandíssimo obrigado pela oportunidade de participar dessa primeira oportunidade do processo,
  o que (sem exageros) me fez aprender mais do que todos os anos de universidade. Cresci muito tecnicamente e também como pessoa,
  adquirindo uma responsabilidade muito grande! Agora aguardo o resultado ansiosamente, com o sonho vivo de entrar nessa empresa que almejo
  desde o primeiro ano de universidade! Mais uma vez, muito obrigado!
  
