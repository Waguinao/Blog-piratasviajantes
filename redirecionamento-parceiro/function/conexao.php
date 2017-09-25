<?php
/*Função para conectar ao banco de dados
 Os parametros da função são declarados como nulos e caso o usuario não insira parametros ele busca no arquivo config.php
 */
function conexaoDb($dbTipo = NULL, $dbServidor = NULL, $dbBancoatual = NULL, $dbUsuario = NULL, $dbSenha = NULL) {
	//Verifco se os valores de todos os campos são diferente de nulos
	if ($dbTipo != NULL and $dbServidor != NULL and $dbBancoatual != NULL and $dbUsuario != NULL and $dbSenha != NULL) {
		//Defino as constantes com os parametros fornecidos pelo usuario
		DEFINE('TIPOBANCO', $dbTipo);
		DEFINE('SERVIDOR', $dbServidor);
		DEFINE('USUARIO', $dbUsuario);
		DEFINE('SENHA', $dbSenha);
		DEFINE('BANCO', $dbBancoatual);
	} else {
		//Inclue as configurações padrões do sistema
		include_once ('config.php');
	}
	//Abre a conexão
	try {
		$conexao = new PDO(TIPOBANCO . ":host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
		$conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexao -> exec('SET NAMES utf8');
		return $conexao;
	} catch(PDOException $erro_log) {
		//Caso exista algum erro, exibo na tela
		echo "Codigo do erro: " . $erro_log -> getCode() . " " . $erro_log -> getMessage();
	}
}
?>