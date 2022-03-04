<script>
    function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
        }
    }
 </script>	

<html>
<head>
	<meta charset="utf-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CIRA - Acesso ao sistema</title>
	<style>
  input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 08px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: "museo-slab"
  }
  input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 08px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: "museo-slab"
  }
  input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "museo-slab"
  }
  
  input[type=submit]:hover {
    background-color: #45a049;
  }
  img {
    max-width: 130%;
    height: auto;
    margin: auto;
    display: block;
  margin-left: -15;
  margin-right: auto;
  width: 115%;
  }
  div {
    border-radius: 5px;
    background-color: #e6e4e4;
    padding: 20px;
    font-family: "museo-slab"
  }
  </style>
</head>

<body>

<table width="200" border="0" align="center">
  <tbody>
    <tr>
      <td align="center"><img src="images/logo prefeitura.png" width="180" height="228" alt=""/></td>
    </tr>
    <tr>
      <td align="center"> 
		  <BR><BR>
		  <?php 
		  	include_once ('functions.php');
		  	limpar_session();
		  	$_SESSION['cns-cidadao']="";
			/* empty = vazia	Só vai retornar false caso a variável seja inicializada com um valor diferente de zero.
			   isset = verifica se existe	 Só irá retornar falso caso a variável seja do tipo NULL 
					1-A variável deixou de existir devido ser destruída com o método unset($teste)
					2-A variável foi declarada sem um valor exemplo: $teste;
					3-A variável está assumindo a constante NULL.
			   is_null 	Retorna um booleano TRUE se $variavel é NULL, FALSE caso contrário.
			*/
		  	
			if (!empty($_POST )) 
			{
				if (($_POST['cns']<>'')and($_POST['senha']<>''))
				{
					$sql = "SELECT * FROM tb_usuario WHERE cns='".$_POST['cns']."' and senha='".$_POST['senha']."'";
					
					$result = pg_query(conectar_banco('esusonline'),$sql);
				
					if (pg_num_rows($result)>0)
					{
						$_SESSION['logado']=true;
						$_SESSION['cns'] = $_POST['cns'];
						$arr = pg_fetch_array($result, NULL, PGSQL_ASSOC);
						$_SESSION['ubs'] = $arr['ubs'];
						$_SESSION['codi_usuario'] = $arr['codigo'];
						header("location: paciente.php");
					} 
					else 
					{
						echo "<p style='color:red;'>" . 'Usuário ou senha inválido!';
					}
				}
					
				else
				{
					echo "<p style='color:red;'>" . 'Digite um CNS e senha!';		
				}
			}
		
		?>
		</td>
    </tr>
    <tr>
      <td><p>
		<form action="index.php" method="post">
        <label for="cns">Digite o seu CNS:</label><br>
        	<input type="text" name="cns" onkeyup="somenteNumeros(this)" maxlength="15">
      </p>
      <p>
        <label for="senha">Senha:</label><br>
			<input type="password" name="senha" onkeyup="somenteNumeros(this)" maxlength="15">
      </p>
      <p>
        <input type="submit" value="Entrar no sistema">
		</form>
    </p></td>
    </tr>
  </tbody>
</table>
</body>
</html>
