<?php
class update_system {
	function lista_arquivos() {
		$diretorio = getcwd();

		$diretorio .= '/_documents/sql/';
		$dr = array();

		$ponteiro = opendir($diretorio);
		while ($nome_itens = readdir($ponteiro)) {
			$itens[] = $nome_itens;
		}

		sort($itens);
		foreach ($itens as $listar) {
			if ($listar != "." && $listar != "..") {
				if (is_dir($listar)) {
					$pastas[] = $listar;
				} else {
					$arquivos[] = $listar;
				}
			}
		}

		if ($arquivos != "") {
			foreach ($arquivos as $listar) {
				$fl = $diretorio . $listar;

				$type = substr($fl, strlen($fl) - 3, 3);
				

				/********************************* Tipos ********************/
				switch($type) {
					
					case 'sql' :
						print " <HR>" . $fl . " <hr>";
						$rlt = fopen($fl, 'r');

						$sql = "";
						while (!(feof($rlt))) {
							$sql .= fread($rlt, 512);
						}
						fclose($rlt);
						rename($fl, $fl . '.ok');

						echo '<PRE>' . $sql . '</pre>';
						$rlt = db_query($sql);
						break;
					default :
						break;
				}
			}
		}
	}

}
?>
