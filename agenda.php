<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Informações do especialista</title>
</head>
<body>
	<?php 
		include_once ('functions.php');			
		if (!empty($_POST )) 
		{
			$_SESSION['codi_especialista']=$_POST['especialista'];
			$sql = "SELECT * FROM tb_especialista_agenda WHERE ((manha>0) OR (tarde>0)) AND  codi_especialista='".$_SESSION['codi_especialista']."' AND data>='".date("Y-m-d")."' ORDER BY data";
			$result = pg_query(conectar_banco('esusonline'),$sql);

			if (pg_num_rows($result)==0)
			{
				echo('<B>Este profissional está com a agenda lotada!</b><BR><BR>Selecione outro especialista ou clique em <a href="anexar.php?cod=00&tur=00" target="_parent">"ENTRAR NA LISTA DE ESPERA"</a>');	
			}
			else
			{
				echo('
				<table border="1" BORDER RULES=rows >
					<tr align="center" bgcolor="#999999">
						<td width="100"><b>Data</b></td>
						<td width="100"><b>Manhã</b></td>
						<td width="100"><b>Tarde</b></td>
					</tr>');
					while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC))
					{	
						echo('<tr  align="center">
						<td>'.date("d/m/Y", strtotime($arr['data'])).'</td>');	
						echo('<td>'); if ($arr['manha']>0){echo('<a href="anexar.php?cod='.$arr['codigo'].'&dat='.$arr['data'].'&tur=1" target="_parent">');} echo($arr['manha'].'</a></td>');	
						echo('<td>'); if ($arr['tarde']>0){echo('<a href="anexar.php?cod='.$arr['codigo'].'&dat='.$arr['data'].'&tur=2" target="_parent">');} echo($arr['tarde'].'</a></td></tr>');	
					}
			}
			echo('
			</table>');
		}
	?>
</body>
</html>