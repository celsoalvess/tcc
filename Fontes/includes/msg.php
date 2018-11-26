<?php
	function mensagem($msg)
	{
		echo "<div id=mensagem style=\"display:block; position:absolute; top:50%;left:50%; margin-left:-150px; margin-top:-100px; padding:10px; width:300px; height:200px; border:1px solid #d0d0d0; background-image: linear-gradient(grey, blue); box-shadow: 10px 10px; text-align: center; font:message-box\"><br><br><br>".$msg."<br><br><a href=\"#\" onclick=\"$('#mensagem').toggle();$('#div_frm').toggle();\">Fechar</a></div>";
	}
	function mensagem2($msg)
	{
		echo "<div id=mensagem style=\"display:block; position:absolute; top:50%;left:50%; margin-left:-150px; margin-top:-100px; padding:10px; width:300px; height:200px; border:1px solid #d0d0d0; background-image: linear-gradient(grey, blue); box-shadow: 10px 10px; text-align: center; font:message-box\"><br><br><br>".$msg."<br><br><a href=\"#\" onclick=\"$('#mensagem').toggle();\">Fechar</a></div>";
	}
?>