<?php
namespace Controllers;

use Models\Pessoa;
use Db\Persiste;

include('Models\Pessoa.php');

class PessoaController{
	public function create($complemento,$json) {
		$obj = json_decode($json);
		$pessoa = new Pessoa($obj->id,$obj->nome,$obj->telefone);
		if (Persiste::Add($pessoa)) {
			http_response_code(200);
			echo '{"Resultado":"Inserido"}';
		} else {
			http_response_code(400);
			echo '{"Resultado":"Falha ao inserir"}';
		}
	}

	public function update($complemento,$json) {
		$obj = json_decode($json);
		$pessoa = new Pessoa($obj->id,$obj->nome,$obj->telefone);
		if (Persiste::Update($pessoa)) {
			http_response_code(200);
			echo '{"Resultado":"Atualizado"}';
		} else {
			http_response_code(400);
			echo '{"Resultado":"Falha ao atualizar"}';
		}
	}

	public function delete($complemento,$json) {
		$obj = json_decode($json);
		$pessoa = new Pessoa($obj->id,$obj->nome,$obj->telefone);
		if (Persiste::Delete($pessoa)) {
			http_response_code(200);
			echo '{"Resultado":"Atualizado"}';
		} else {
			http_response_code(400);
			echo '{"Resultado":"Falha ao atualizar"}';
		}
	}
}

?>
