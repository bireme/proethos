<?
/**
 * Documents
 * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
 * @version 1.0m
 * @copyright Copyright - 2012, Rene F. Gabriel Junior.
 * @access public
 * @package ProEthos
 * @subpackage documents
 */

/* mark active page to cabmenu */
$active_page = 'docs';

/* Without security */
$nosec = 1;

/* Load Header */
require ("cab.php");

/* Load library */
require ($include . 'sisdoc_data.php');
require ('_class/_class_documents.php');
require ("_ged_documents.php");

$documents = new documents;

/* Sessao e pagina da Submissao */

echo '<H1>' . msg('documents_title') . '</h1>';

echo '<BR>';
echo '<fieldset>';

echo '<div>';
echo '<div style="float: left; margin-right: 5px;">Sort by:</div>';
echo '<div style="float: left; margin-right: 5px; text-decoration: underline;">DATE</div>';
echo '<div style="float: left; margin-right: 5px;">TYPE</div>';
echo '</div>';

echo '<Table width="' . $tab_max . '" class="lt1" align="center" >';
echo '<TR><TD>';
$sql = "select * from ged_documento_tipo 
		where (doct_publico = 1) ";

/* Restricted documents to members */
if ($perfil -> valid('#MEM')) { $sql .= " or (doct_publico = 0) ";
}

/* Executa busca */
$rlt = db_query($sql);

while ($line = db_read($rlt)) {
	$ged -> protocol = strzero(round($line['doct_codigo']), 7);
	$sx = '<h2>' . utf8_encode(msg(trim($line['doct_nome']))) . '</h2>';
	$ged -> table_class = "tabela00";

	$sx .= $ged -> filelist_download();
	if ($ged -> total_files > 0) { echo($sx);
	}
}
echo '</table>';
echo '</fieldset>';


require ("documents_proethos.php");
echo '</div>';

echo $hd -> foot();
?>
<script></script>

