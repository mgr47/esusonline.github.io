<?php
   function upload($tmp, $arquivo, $max_x, $max_y, $pasta){
   //$max_x = 800 $max_y = 630
   $img		= imagecreatefromjpeg($tmp);
   $original_x	= imagesx($img); //largura
   $original_y	= imagesy($img); //altura
   $diretorio	= $pasta."/".$arquivo;
   // verifica se a largura ou altura da imagem é maior que o valor
   // máximo permitido
   if ( ( $original_x > $max_x ) || ( $original_y > $max_y ) ){
	// verifica o que é maior na imagem, largura ou altura?
        if ( $original_x > $original_y ) {
		$max_y	= ( $max_x * $original_y ) / $original_x;
	}else{
		$max_x	= ( $max_y * $original_x ) / $original_y;
	}
	$nova = imagecreatetruecolor($max_x, $max_y);
	imagecopyresampled($nova, $img, 0, 0, 0, 0, $max_x, $max_y, $original_x, $original_y);
	imagejpeg($nova, $diretorio);
	imagedestroy($nova);
	imagedestroy($img);
   // se for menor, nenhuma alteração é feita
   }else{
	imagejpeg($img, $diretorio);
	imagedestroy($img);
   }
   return($arquivo);
}
?>
