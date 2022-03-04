<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Anexar encaminhamento</title>
</head>
	<table width="345" border="1" align="center" cellpadding="7">
		<tr>
			<td>
				<?php 
					include_once ('functions.php');		
					if(isset($_FILES['file']))
					{
						//Selecionar último registro e incrementar 1
						$sql = "SELECT last_value AS codigo FROM tb_agendamento_codigo_seq";
						$result = pg_query(conectar_banco('esusonline'),$sql);
						$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);	
						$_SESSION['nome_anexo']=$arr['codigo']+1;
						
						
						$arquivo = $_FILES['file'];	
						if ($arquivo['tmp_name']<>'')
						{
                            // Funcao que redimensiona e faz upload da imagem
                            require ('redimensiona_fotos.php');
                            $result = upload($arquivo['tmp_name'], $_SESSION['nome_anexo'].'.png', 800, 600, 'images');
                            // o retorno da fun��o � o nome do arquivo
							
							//inserir o registro
							$sql = "INSERT INTO tb_agendamento (cns, nome, sexo, nascimento, ubs, acs, whats, telefone, recado, recado_nome, codi_especialidade, codi_especialista, diagnostico,cid,agen_data, agen_hora, agen_codi_usuario, codi_especialista_agenda, turno, data_consulta)
							VALUES ('".$_SESSION['cns-cidadao']."','".$_SESSION['nome']."','".$_SESSION['sexo']."','".date("Y-m-d", strtotime($_SESSION['nascimento']))."','".$_SESSION['ubs']."','".$_SESSION['acs']."','".$_SESSION['whatsapp']."','".$_SESSION['telefone']."','".$_SESSION['recado']."','".$_SESSION['recado_nome']."','".$_SESSION['codi_especialidade']."','".$_SESSION['codi_especialista']."','".$_SESSION['diagnostico']."','".$_SESSION['cid']."','".date("Y-m-d")."','".date('H:i:s')."','".$_SESSION['codi_usuario']."','".$_SESSION['codi_especialista_agenda']."','".$_SESSION['turno']."','".date("Y-m-d", strtotime($_SESSION['dat']))."')";
							
							$_SESSION['sql']=$sql;
							$result = pg_query(conectar_banco('esusonline'),$sql);
							$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);

							//diminuir 1 vaga na agenda do especialista
							$result = pg_query(conectar_banco('esusonline'),$_SESSION['sql_vagas']);
							
							header("location: comprovante.php");	
						}
						else
						{							
							echo("<b>ATENÇÃO!<br> Nenhum encaminhamento médico foi anexado.</b><br><br>");
						}
					}
					else
					{
						if ($_GET['tur']==0) 
						{
							$_SESSION['sql_vagas'] = "";
							$_SESSION['turno']='';
						}
						if ($_GET['tur']==1) 
						{
							$_SESSION['sql_vagas'] = "UPDATE tb_especialista_agenda SET manha = manha-1 WHERE codigo=".$_GET['cod'];
							$_SESSION['turno']='Manhã';
							$_SESSION['dat']=$_GET['dat'];
						}
						if ($_GET['tur']==2) 
						{ 
							$_SESSION['sql_vagas'] = "UPDATE tb_especialista_agenda SET tarde = tarde-1 WHERE codigo=".$_GET['cod'];
							$_SESSION['turno']='Tarde';
							$_SESSION['dat']=$_GET['dat'];
						}
						$_SESSION['codi_especialista_agenda']=$_GET['cod'];
					}			
				?>
				
				<form action="anexar.php" enctype="multipart/form-data" method="post">
				<label for="file">Fotografe o encaminhanto médico:</label><br>	
				<input name="file" type="file" />
					<BR><BR><BR><BR>
				<input name="submit" type="submit" value="CONFIRMAR AGENDAMENTO" />
				</form>
			</td>
		</tr>
	</table>
<body>
</body>
</html>
