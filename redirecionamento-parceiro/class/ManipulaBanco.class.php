<?php
include_once ('function/conexao.php');
class ManipulaBanco {
	function inserirRegistro($tabela, $data) {
		try{
			$conexao = conexaoDb();
			$fildes = implode(', ', array_keys($data));
			$values = ":" . implode(', :', array_keys($data));
			$db_inserir = $conexao -> prepare("INSERT INTO {$tabela} ({$fildes})VALUES({$values})");
			foreach ($data as $key => $valor) {
				$db_inserir -> bindValue($key, $valor);
			}
			//var_dump($db_inserir);
			$db_inserir -> execute();
			return true;
		} catch(PDOException $erro_log) {			
			switch ($erro_log -> getCode()) {
				case '23000':
					return $erro_log -> getCode();
					break;
			}			
		}
		
	}

	function selecionarRegistro($tabela, $campos = "*", $parametos = NULL, $order = NULL, $limit = NULL) {
		date_default_timezone_set('America/Sao_Paulo');
		$conexao = conexaoDb();
		//$conexao -> exec('SET NAMES utf8');
		$parametos = ($parametos) ? " {$parametos}" : NULL;
		$limit = ($limit) ? " {$limit}" : NULL;
		$order = ($order) ? " {$order}" : NULL;
		$DB_Consulta = $conexao -> prepare("SELECT {$campos} FROM {$tabela}{$parametos}{$order}{$limit}");
		//falha de segurança;
		$DB_Consulta -> execute();
		$Data_retorno = $DB_Consulta -> fetchALL(PDO::FETCH_OBJ);
		return $Data_retorno;
	}

	function atualizarRegistro($tabela, $data, $parametro) {
		try {
			foreach ($data as $key => $value) {
				$fildes[] = $key . "= :" . $key;
			}
			$fildes = implode(', ', $fildes);
			$conexao = conexaoDb();
			$db_atualiza = $conexao -> prepare("UPDATE {$tabela} SET {$fildes} WHERE {$parametro}");
			foreach ($data as $key => $valor) {
				$db_atualiza -> bindValue($key, $valor);
			}
			$db_atualiza -> execute();
			$db_atualiza = NULL;
			return true;
		} catch(PDOException $erro_log) {
			echo "Codigo do erro: " . $erro_log -> getCode() . " " . $erro_log -> getMessage();
			return FALSE;
		}

	}

	function deletarRegistro($tabela, $alvo) {
		try {
			foreach ($alvo as $key => $value) {
				$fildes[] = $key . "= :" . $key;
			}
			$fildes = implode(', ', $fildes);
			$conexao = conexaoDb();
			$db_deleta = $conexao -> prepare("DELETE FROM {$tabela} WHERE {$fildes}");
			foreach ($alvo as $key => $valor) {
				$db_deleta -> bindValue($key, $valor);
			}
			$db_deleta -> execute();
			return TRUE;
		} catch(PDOException $erro_log) {
			echo "Codigo do erro: " . $erro_log -> getCode() . " " . $erro_log -> getMessage();
			return FALSE;
		}
	}

}
?>
