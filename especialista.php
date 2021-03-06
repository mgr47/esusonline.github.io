<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Informações do especialista</title>
	<style>
		input[type=text], select {
		  width: 100%;		  
		  padding: 12px 20px;
		  margin: 08px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;
		  font-family: arial;
		}
		input[type=password], select {
		  width: 100%;
		  padding: 12px 20px;
		  margin: 08px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;
		  font-family: arial;
		}
		input[type=submit], select {
		  background-color: #4CAF50;
		  width: 100%;
		  color: white;
		  padding: 14px 20px;
		  margin: 8px 0;
		  border: none;
		  border-radius: 4px;
		  cursor: pointer;
		  font-family: arial;
		}
		input[type=date], select {
		  width: 48%;
		  right:100%;		  
		  padding: 12px 20px;
		  margin: 08px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;
		  font-family: arial;
		}
		table {
			margin: 0 auto;
			border: 1;
			font-family: arial;
		}
		input[type=submit]:hover {
		  background-color: #45a049;
		}
		</style>
</head>
<body>
	<table width="345" cellpadding="7">
		<tr>
			<td>
				<?php 
					include_once ('functions.php');		
					if (!empty($_POST)) 
					{
						$_SESSION['nome']=$_POST['nome'];
						$_SESSION['sexo']=$_POST['sexo'];
						$_SESSION['nascimento']=$_POST['nascimento'];
						$_SESSION['ubs']=$_POST['ubs'];
						$_SESSION['acs']=$_POST['acs'];
						$_SESSION['codi_especialidade']=$_POST['especialidade'];
						
						$sql = "SELECT * FROM tb_especialidade WHERE codigo='".$_SESSION['codi_especialidade']."'";
						$result = pg_query(conectar_banco('esusonline'),$sql);
						while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC))
						{	
							$_SESSION['especialidade']=$arr['especialidade'];	
						}
		
						$_SESSION['whatsapp']=$_POST['whatsapp'];
						$_SESSION['telefone']=$_POST['telefone'];
						$_SESSION['recado']=$_POST['recado'];
						$_SESSION['recado_nome']=$_POST['recado_nome'];
						$_SESSION['diagnostico']=$_POST['diagnostico'];
						$_SESSION['cid']=$_POST['cid'];
					}
					//se não tiver registrado o CNS volta para a pagina paciente.php	
					if (empty($_SESSION['cns-cidadao']))
					{
						header("location: paciente.php?semcns=1");	
					}
						echo("CNS: ".$_SESSION['cns-cidadao']."<br>");
						echo("Nome: ".$_SESSION['nome']."<br>");
						echo("Sexo: ".$_SESSION['sexo']."<br>");
						echo("Nascimento ".date("d/m/Y",strtotime($_SESSION['nascimento']))."<br>");
						echo("UBS: ".$_SESSION['ubs']."<br>");
						echo("ACS: ".$_SESSION['acs']."<br>");
						echo("WhatsApp: ".$_SESSION['whatsapp']."<br>");
						echo("Telefone: ".$_SESSION['telefone']."<br>");
						echo("Recado: ".$_SESSION['recado']."<br>");
						echo("Nome: ".$_SESSION['recado_nome']."<br>");
						echo("Código Especialidade: ".$_SESSION['codi_especialidade']."<br>");
						echo("Especialidade: ".$_SESSION['especialidade']."<br>");
						echo("Diagn&oacute;stico: ".$_SESSION['diagnostico']."<br>");
						echo("CID: ".$_SESSION['cid']."<br>");
						echo("---------------------------------------------<br>");
				?>
				<form action="agenda.php" target="my-iframe" method="post">
				<label for="especialista">Especista:</label><br>
				<select name="especialista">					
					<?php 
						$sql = "SELECT * FROM tb_especialista WHERE codi_especialidade='".$_SESSION['codi_especialidade']."' ORDER BY especialista";
						$result = pg_query(conectar_banco('esusonline'),$sql);
						while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC))
						{	
							echo ('<option value="'.$arr['codigo'].'">'.$arr['especialista'].'</option>');	
						}
						echo "<p style='color:red;'>" . 'Usuário ou senha inválido!';
					?>
				</select>
					<input type="submit" value="Consultar Agenda">
					<BR>
					<BR>
					<iframe name="my-iframe" src="agenda.php" height="200" width="300" title="my-iframe"></iframe>
			</td>
		</tr>
	</table>
</body>
</html>