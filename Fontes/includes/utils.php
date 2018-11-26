<?php
	function senhaGerador()
	{
		$carac = 'abcdefghijklmnopqrstuvwxyz1234567890';
		$senha = '';
			
		for ($n = 1; $n <= 8; $n++) 
		{
			$randon = mt_rand(1, 8);
			$senha .= $carac[$randon-1];
		}

		return $senha;
	}
?>