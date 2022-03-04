<?php
date_default_timezone_set('Brazil/East');
session_start();

function conectar_banco($nome_banco)
{
	$db_user 	 = "esusonline";
	$db_port 	 = "5432";
	$db_password = "osvaldir21";
	$db_host 	 = "pgsql.esusonline.com.br";

	return pg_connect("host=".$db_host." port=".$db_port." dbname=".$nome_banco." user=".$db_user." password=".$db_password);	
}

function conectar_esus($nome_banco)
{
	$db_user 	 = "postgres";
	$db_port 	 = "54051";
	$db_password = "esus";
	$db_host 	 = "barreirinhas.esusonline.com.br";

	return pg_connect("host=".$db_host." port=".$db_port." dbname=".$nome_banco." user=".$db_user." password=".$db_password);	
}

function localizar_registro($sql)
{

}

function verificar_imprimir ($campo_formulario)
{
	if (isset($_SESSION[$campo_formulario]))
	{
		return ' value="'.$_SESSION[$campo_formulario].'"';
	}
}

function verificar_imprimir_so_texto ($campo_formulario)
{
	if (isset($_SESSION[$campo_formulario]))
	{
		return $_SESSION[$campo_formulario];
	}
}

function limpar_session()
{
	$_SESSION["logado"] 	= false;

		/*$arr = array("codigo","data_cadastro","hora_cadastro");
	foreach ($arr as &$value) {*/
	$_SESSION['cns-cidadao']= "";
	$_SESSION["nome"] 		= "";
	$_SESSION["sexo"] 		= "";
	$_SESSION["nascimento"] = "";
	$_SESSION["ubs"] 		= "";
	$_SESSION["acs"] 		= "";
	$_SESSION["whatsapp"] 		= "";
	$_SESSION["telefone"] 	= "";
	$_SESSION["recado"] = "";
	$_SESSION["recado_nome"] = "";
	$_SESSION["codi_especialidade"] = "";
	$_SESSION["especialidade"] 	= "";
	$_SESSION["diagnostico"] 	= "";
	$_SESSION["cid"] 			= "";
	
	$_SESSION['codi_especialista_agenda']="";
	$_SESSION['turno']			="";
	$_SESSION['sql_vagas']		="";
	$_SESSION['nome_anexo']		="";
	$_SESSION['dat']			="";
	
	$_SESSION['sql']			="";
}
?>
