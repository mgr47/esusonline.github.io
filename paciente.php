<script type="text/javascript">
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){
	id('whatsapp').onkeyup = function()	{
		mascara( this, mtel );
	}
	id('telefone').onkeyup = function()	{
		mascara( this, mtel );
	}
	id('recado').onkeyup = function()	{
		mascara( this, mtel );
	}
}

function handleInput(e) {
   var ss = e.target.selectionStart;
   var se = e.target.selectionEnd;
   e.target.value = e.target.value.toUpperCase();
   e.target.selectionStart = ss;
   e.target.selectionEnd = se;
}
</script>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Informações do paciente</title>
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
					if ((!empty($_GET))and($_GET['semcns']==1)){
					echo "<p style='color:red;'>" . 'Digite o CNS do cidadão e clique em BUSCAR!';		
					}
					if (!empty($_POST )) 
					{
						$ubs=$_SESSION['ubs'];
						limpar_session();
						$_SESSION['ubs']=$ubs;
						$_SESSION['cns-cidadao'] = $_POST['cns-cidadao'];
						
						if ($_POST['cns-cidadao']<>'')
						{
							$sql = "SELECT * FROM tb_cidadao WHERE nu_cns='".$_POST['cns-cidadao']."'";

							$result = pg_query(conectar_esus('esus'),$sql);
							if (pg_num_rows($result)>0)
							{
								$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);	
								$_SESSION['cns-cidadao'] = $_POST['cns-cidadao'];
								$_SESSION['nome'] 		 = $arr['no_cidadao'];
								$_SESSION['sexo'] 		 = $arr['no_sexo'];
								$_SESSION['nascimento']  = $arr['dt_nascimento'];
								if ($arr['nu_telefone_celular']!='98000000000') 
								{
									$_SESSION['telefone'] = $arr['nu_telefone_celular'];
								}
								else
								{
									$_SESSION['telefone'] = "";
								}
							}
							else
							{
								echo "<p style='color:red;'>" . 'Dados não localizados! Digite manualmente.';
								$_SESSION['cns-cidadao'] = $_POST['cns-cidadao'];
							}
						}
						else
						{
							echo "<p style='color:red;'>" . 'Digite o CNS do cidadão!';
							$_SESSION['cns-cidadao'] = '';
						}
					}
				?>
				<form action="paciente.php" method="post">
					<label for="textfield">Digite o CNS do paciente:</label><br>
					<input type="text" name="cns-cidadao"<?php echo(verificar_imprimir('cns-cidadao')); ?>>
					<input type="submit" value="Buscar">
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<form action="especialista.php" method="post">
					<label for="textfield">Nome:</label><br>
					<input type="text" name="nome" size=35
						   <?php echo(verificar_imprimir('nome')); ?> oninput="handleInput(event)" />
					<BR>
					<input type="radio" name="sexo" value="MASCULINO"
						   <?php if (isset($_SESSION['sexo'])){ if ($_SESSION['sexo']=='MASCULINO'){echo ' checked=true';}}?>>Masculino
					<input type="radio" name="sexo" value="FEMININO"
						   <?php if (isset($_SESSION['sexo'])){ if ($_SESSION['sexo']=='FEMININO'){echo ' checked=true';}}?>>Feminino
					<BR>
					<BR>
					<label for="textfield">Nascimento:</label><br>
					<input type="date" name="nascimento" 
						   <?php echo(verificar_imprimir('nascimento')); ?>>
					<BR>
					<label for="ubs">UBS:</label><br>
					<input type="text" name="ubs" size=35
						   <?php echo(verificar_imprimir('ubs')); ?>>
					<BR>
					<label for="acs">ACS:</label><br>
					<input type="text" name="acs" size=35
						   <?php echo(verificar_imprimir('acs')); ?>>
			</td>
		</tr>
		<tr>
			<td bgcolor="#DDDDDD">
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<label for="whatsapp">WhatsApp:</label><br>
							<input type="text" name="whatsapp" id="whatsapp" size=15 maxlength="15"<?php echo(verificar_imprimir('whatsapp')); ?>>
						</td>
						<td>
							<label for="telefone">Telefone:</label><br>
							<input type="text" name="telefone" id="telefone" size=15 maxlength="15"<?php echo(verificar_imprimir('telefone')); ?>>
						</td>
					</tr>
					<tr>
						<td>
							<label for="recado">Telefone p/ recado:</label><br>
							<input type="text" name="recado" id="recado" size=15 maxlength="15"<?php echo(verificar_imprimir('recado')); ?>>	
						</td>
						<td>
							<label for="recado_nome">Nome:</label><br>
							<input type="text" name="recado_nome" id="recado" size=15 maxlength="35"<?php echo(verificar_imprimir('recado_nome')); ?>>	
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
		<tr>
			<td>
					<label for="especialidade">Especialidade solicitada:</label><br>
					<select name="especialidade">
						<?php 
							$sql = "SELECT * FROM tb_especialidade ORDER BY especialidade";

							$result = pg_query(conectar_banco('esusonline'),$sql);
							while($arr = pg_fetch_array($result, NULL, PGSQL_ASSOC))
							{	
								echo ('<option value="'.$arr['codigo'].'"');
									  if ($arr['codigo']==$_SESSION['codi_especialidade']){echo('selected="true"');}
								echo ('>'.$arr['especialidade'].'</option>'."\n");	
							}
						?>
					</select>  &nbsp; &nbsp;
					<input type="checkbox" name="urgencia" id="urgencia">Urg&ecirc;ncia<br>
					<BR>
					<label for="telefone">Diagn&oacute;stico:</label><br>
					<textarea rows="2" cols="42" wrap="physical" name="diagnostico"><?php echo(verificar_imprimir_so_texto('diagnostico')); ?></textarea>
					<BR>
					<label for="cid">CID:</label><br>
					<input type="text" name="cid" size=15<?php echo(verificar_imprimir('cid')); ?> value="">
					
					<input type="submit" value="Continuar">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
