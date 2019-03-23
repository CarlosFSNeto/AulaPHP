<?php

namespace Db; // agrupamento de classes (caminho)

// Referências a classes do PHP
use \PDO;
use \PDOException;
use \ReflectionClass;
// Obs.: PDO implementa interação com Banco de Dados

// Inclui dados para conexão com banco de dados
include('ConfiguracaoConexao.php');

// Classe (ou Tipo) de Objeto
// obs.: Implementa métodos para inserção, deleção, alteração e recuperação de objetos persistidos em banco de dados
class Persiste{

	// Método para adicionar objeto ao banco de dados
	public static function Add($obj){

		// ReflectionClass é usado para inspecionar a estrutura da classe de $obj
		$rf = new ReflectionClass($obj);

		// Obtem o nome da classe (da tabela no BD)
		$aux = explode("\\",$rf->name);
		$classe = array_pop($aux);

		$nomesColunas = "";
		$valoresColunas = "";

		foreach($rf->getProperties() as $v){
			$nomesColunas .= strlen($nomesColunas)==0 ?$v->name : ','.$v->name;
			$valoresColunas .= strlen($valoresColunas) ==0 ? "'".$obj->{'get'.$v->name}."'" : ",'".$obj->{'get'.$v->name}."'";
		}

        // Monta comando SQL
        $sql = "insert into $classe (".$nomesColunas.") values (".$valoresColunas.")";

		try {
			// Cria objeto PDO
			$c = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Executa comando SQL
			$c->exec($sql);

			$retorno = true;

		// Desvia para catch no caso de erros.
		} catch (PDOException $pex) {
			echo $pex->getMessage();
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		} finally {
			$c=null;
		}

		return $retorno;
	}

	public static function Update($obj){
		// ReflectionClass é usado para inspecionar a estrutura da classe de $obj
		$rf = new ReflectionClass($obj);

		// Obtem o nome da classe (da tabela no BD)
		$aux = explode("\\",$rf->name);
		$classe = array_pop($aux);

        // Monta comando SQL
        $sql = "update $classe set ";

		foreach($rf->getProperties() as $v){
			$sql .= $v->name . " = '" . $obj->{'get'.$v->name} . "', ";
		}

		$sql = substr($sql, 0, -2);

		$sql .= " where id = " . $obj->{'getid'};

		//echo $sql;

		try {
			// Cria objeto PDO
			$c = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Executa comando SQL
			$c->exec($sql);

			$retorno = true;

		// Desvia para catch no caso de erros.
		} catch (PDOException $pex) {
			echo $pex->getMessage();
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		} finally {
			$c=null;
		}

		return $retorno;
	}

	public static function Delete($obj){
		$rf = new ReflectionClass($obj);

		$aux = explode("\\", $rf->name);
		$classe = array_pop($aux);

		$sql = "delete from $classe where id = " . $obj->{'getid'};

		try {
			// Cria objeto PDO
			$c = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Executa comando SQL
			$c->exec($sql);

			$retorno = true;

		// Desvia para catch no caso de erros.
		} catch (PDOException $pex) {
			echo $pex->getMessage();
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		} finally {
			$c=null;
		}

		return $retorno;
	}

	public static function Find($nomeClasse, $id){
		$sql = "select * from $nomeClasse where id = :id";

		//TODO
		try {
			// Cria objeto PDO
			$c = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Executa comando SQL
			$stmt = $c->prepare($sql);
			$stmt->execute([':id' => $id]);

			$retorno = $stmt->fetch();

		// Desvia para catch no caso de erros.
		} catch (PDOException $pex) {
			//echo $pex->getMessage();
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		} finally {
			$c=null;
		}

		return $retorno;
	}

	public static function FindAll($nomeClasse){
		$sql = "select * from $nomeClasse";

		//TODO
		try {
			// Cria objeto PDO
			$c = new PDO(hostDb,usuario,senha);

			// Configura o comportamento no caso de erros: levanta exceção.
			$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Executa comando SQL
			$stmt = $c->prepare($sql);
			$stmt->execute();

			$retorno = $stmt->fetchAll();

		// Desvia para catch no caso de erros.
		} catch (PDOException $pex) {
			//echo $pex->getMessage();
			$retorno = false;

		// Sempre executa o bloco finally, tendo ocorrido ou não erros no bloco TRY
		} finally {
			$c=null;
		}

		return $retorno;
	}
}
?>
