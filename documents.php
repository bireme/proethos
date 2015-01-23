<?
/**
 * Documents
 * @author Rene F. Gabriel Junior <renefgj@gmail.com>
 * @version 1.0m
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
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

$sx = '<H1>' . msg('documents_title_commite') . '</h1>';
$sx .= '<fieldset>';
$sx .= '<Table width="100%" class="tabela00" align="center" >';
$sx .= '<TR><TD>';

$sql = "select * from ged_documento_tipo 
		where (doct_publico = 1) ";

/* Restricted documents to members */
if ($perfil -> valid('#MEM')) { $sql .= " or (doct_publico = 0) ";
}

/* Executa busca */
$rlt = db_query($sql);

$to = 0;
while ($line = db_read($rlt)) {
	$ged -> protocol = strzero(round($line['doct_codigo']), 7);
	$sf = '<h2>' . utf8_encode(msg(trim($line['doct_nome']))) . '</h2>';
	$ged -> table_class = "tabela01";

	$sf .= $ged -> filelist_download();
	$to = $to + $ged -> total_files;
	}
$sx .= $sf;
$sx .= '</table>';
$sx .= '</fieldset>';

if ($to > 0) { echo $sx; }

echo '<BR>';
echo '<H1>' . msg('documents_title') . '</h1>';
echo '<fieldset>';
require ("documents_proethos.php");
echo '</div>';
echo '</fieldset>';

echo $hd -> foot();
?>
<script></script>

