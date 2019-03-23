<?php
	// CORS - Servidor define quais domínios diferentes podem acessar recursos da aplicação. Neste exemplo, qualquer domínio (*)
	header("Access-Control-Allow-Origin: *");
	
	// CORS - Servidor define os métodos permitidos
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
	
	// Define o tipo do retorno
	header("Content-Type: application/json; charset=UTF-8");
	
	// Converte as células do vetor $_SERVER em variáveis
    extract($_SERVER);
    
    // Obtém todo o conteúdo do input padrão. No caso, string JSON (dados)
	$json = file_get_contents("php://input");
	
	// Obtém o recurso que está sendo acessado. Por exemplo, se URL for "http://localhost/phpobjetos/api.php/funcionario" $PATH_INFO será "/funcionario" e, portanto, o recurso funcionário está sendo consultado ou alterado.
    $pi = explode('/',$PATH_INFO);
	$recurso = $pi[1];
	$complemento = isset($pi[3]) ? $pi[3] : null;

	// Determina qual função do Controller vai ser acionada para tratar a requisição
	if ($REQUEST_METHOD=='GET') {
		if ($complemento==null) {
			$funcao = "getAll";
		} else {
			$função = "get";
		}
	} else if($REQUEST_METHOD=='POST'){
		$funcao = "create";
	} else if($REQUEST_METHOD=='PUT'){
		$funcao = "update";
	} else if($REQUEST_METHOD=='DELETE'){
		$funcao = "delete";
	}

    // Instancia controller conforme nome do recurso
    $nomeController = 'Controllers\\'.ucfirst($recurso).'Controller';
    include($nomeController.'.php');
    $controller = new $nomeController();
    $resultado = $controller->{$funcao}($complemento,$json);

/*
URL+Método e status code
=======================

Consultar objeto
----------------
Método: Get (um ou vários objetos)
URL: /recurso		Todos
URL: /recurso/id 	Um
200 ok
404 not found

Criar objeto
------------
Método: Post
URL: /recurso
201 create
503 service unvaliable
400 bad request - dados inválidos

Atualizar objeto
----------------
Método: Put
URL: /recurso
200 ok
503 service unvaliable
400 bad request - dados inválidos

Excluir objeto
--------------
Método: Delete
URL: /recurso
200 ok
503 service unvaliable
*/

?>