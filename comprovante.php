<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Anexar encaminhamento</title>
</head>
	<table width="345" border="1" align="center" cellpadding="7">
		<tr>
			<td align="center">
				<?php
					include_once ('functions.php');		
					$sql = "SELECT * FROM tb_agendamento WHERE codigo='".$_SESSION['nome_anexo']."'";
					$result = pg_query(conectar_banco('esusonline'),$sql);
					$texto_whats='*ATEN&Ccedil;&Atilde;O, N&Atilde;O RESPONDA ESTA MENSAGEM POIS ELA FOI ENVIADA POR UM COMPUTADOR!* %0A
-------------------------------------------------------------%0A';
					$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);
				
					if (($arr['turno']=='Manhã')or($arr['turno']=='Tarde'))
					{
						echo ('<B><font size="4">COMPROVANTE DE <BR>AGENDAMENTO DE CONSULTA</font></B><br>');	
						$texto_whats=$texto_whats.'COMPROVANTE DE AGENDAMENTO DE CONSULTA%0A';
					}
					else
					{
						echo ('<B><font size="4">COMPROVANTE DE <BR>ENTRADA NA LISTA DE ESPERA</font></B><br>');
						$texto_whats=$texto_whats.'COMPROVANTE DE ENTRADA NA LISTA DE ESPERA%0A';		
					}
					echo("Protocolo: 21OK-".$_SESSION['nome_anexo']."<BR>");
					$texto_whats=$texto_whats.'Protocolo: 21OK-'.$_SESSION['nome_anexo'].'%0A
-------------------------------------------------------------%0A';
					echo("
					
			</td>
		</tr>
		<tr>
			<td>");
		
					if (($arr['turno']=='Manhã')or($arr['turno']=='Tarde'))
					{
						echo("<b>Data da consulta:</b> ".date("d/m/Y", strtotime($arr['data_consulta']))."<br>");
						$texto_whats=$texto_whats.'*Data da consulta:* '.date("d/m/Y", strtotime($arr['data_consulta'])).'%0A';
						echo("<b>Turno:</b> ".$arr['turno']."<br><br>");
						$texto_whats=$texto_whats.'*Turno:* '.$arr['turno'].'%0A';
					}
					else
					{	
						echo("<b>Data da consulta: Aguarde contato da central</b><br>");
						$texto_whats=$texto_whats.'*Data da consulta:* Aguarde contato da central%0A';
						echo("<b>Turno: A definir, de acordo com a agenda</b><br><br>");
						$texto_whats=$texto_whats.'*Turno:* A definir, de acordo com a agenda%0A%0A';
					}
					echo("<b>Especialidade:</b> ".$_SESSION['especialidade']."<br>");
					$texto_whats=$texto_whats.'Especialidade: '.$_SESSION['especialidade'].'%0A';
					
					//pegar o código do especialista que está armazenado na session e retornar o nome do profissional
					$sql2 = "SELECT * FROM tb_especialista WHERE codigo='".$_SESSION['codi_especialista']."'";
					$result2 = pg_query(conectar_banco('esusonline'),$sql2);
					$arr2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC);	
					echo("<b>Especialista:</b> ".$arr2['especialista']."<br><BR>");
					$texto_whats=$texto_whats.'Especialista: '.$arr2['especialista'].'%0A
*Local:* Centro de Especialidades M&eacute;dicas%0A
Rua In&aacute;cio Lins, 52 - Centro - Barreirinhas - MA%0A
Próximo a F&aacute;brica de gelo/Em frente a Quality Odonto%0A
-------------------------------------------------------------%0A';
					
					$texto_whats=$texto_whats.'No dia da consulta é obrigatória a apresenta&ccedil;&atilde;o do Cartão do SUS e Encaminhamento m&eacute;dico%0A';
					//echo("---------------------------------------------<br>");
					echo("CNS: ".$_SESSION['cns-cidadao']."<br>");
					echo("Nome: ".$_SESSION['nome']."<br>");
					echo("Sexo: ".$_SESSION['sexo']."<br>");
					echo("Nascimento ".date("d/m/Y",strtotime($_SESSION['nascimento']))."<br>");
				echo("
			</td>
		</tr>
		<tr>
			<td align='center'> <font size='2'>");
					echo("Data do agendamento: ".date("d/m/Y", strtotime($arr['agen_data']))." &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Hora: ".$arr['agen_hora']."<BR>");
					if (($_SESSION['whatsapp'])!="")
					{
					 	echo('<BR><a href="https://wa.me/55'.preg_replace('/[^0-9]/', '',$_SESSION['whatsapp']).'?text='.$texto_whats.'">Enviar comprovante pelo WhatsApp</a>');
					}
					limpar_session(); 
				?>	
			</td>
		</tr>
	</table>
<body>
</body>
</html>