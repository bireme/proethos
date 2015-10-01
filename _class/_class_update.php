<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt


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