<?
    /**
     * Ged - upload file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package index
	 * @subpackage ged
    */
    
require("db.php");
require($include.'sisdoc_debug.php');

/* Check */
$id = $dd[0];
$chk = checkpost($id);

if ($chk != $dd[90])
	{
		echo 'Post error';
		exit;
	}

require("_ged_config.php");
$sql = "update ".$ged->tabela." set doc_ativo = 0 where id_doc = ".$dd[0];
$rlt = db_query($sql);

require("close.php");
?>
