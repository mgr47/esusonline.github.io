<?php
if(isset($_FILES['file']))
{
   $pasta = 'images';
   $arquivo = $_FILES['file'];
   $temp = $arquivo['tmp_name'];
   $filename = $arquivo['name'];

   echo("pasta: $pasta <br>");
   echo("arquivo: array <br>");
   echo("temp: $temp <br>");
   echo("filename: $filename <br>");
   $largura_max	= 800;
   $altura_max	= 630;
   // arquivo que contÈm a funÁ„o
   require ('redimensiona_fotos.php');
   // funcao que redimensionar· a imagem
   // o retorno da funÁ„o È o nome do arquivo
   $result = upload($temp, $filename, $largura_max, $altura_max, $pasta);
   // gravando nome do arquivo no banco de dados
  // $insert = mysql_query("INSERT INTO nome_tabela (arquivo_imagem) VALUES ('".$result."')");
}
?>
<form action="teste.php" method="post" enctype="multipart/form-data">
   	<label for="file">Fotografe o encaminhanto m√©dico:</label><br>
   <input name="file" type="file" />
   <br />
   <input type="submit" name="submit" value="Enviar" />
</form>
