<?
$include = '';
require("db.php");
require($include.'sisdoc_colunas.php');
/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }
$LANG = $lg->language_read();
$edit_mode = round($_SESSION['editmode']);

if ($dd[10] == 'test')
	{
		echo '<font color="green">TEST OK</font>';
		exit;
	}
if ($dd[10] == 'country')
	{
		// Orcamento
		require("_class/_class_ajax_pais.php");
		$bd = new country;
		$desc = $dd[1];
		$proto = $dd[11];
		$target = round($dd[2]);
		if (strlen($desc) > 0)
			{
				$bd->country_iten_insert($proto,$desc,$target);	
			}
		
		if (($dd[12]=='DEL') and (strlen($dd[0])> 0))
			{
				$bd->country_iten_del($dd[0],$proto);
				echo $bd->country_list($proto);
			} else {
				echo $bd->country_list($proto);			
			}
	}

if ($dd[10] == 'budget')
	{
		// Or�amento
		require("_class/_class_budget.php");
		$bd = new budget;
		$quan = round($dd[2]);
		$valr = round($dd[3]*100)/100;
		$desc = $dd[1];
		$proto = $dd[11];
		if (($quan > 0) and ($valr > 0) and (strlen($proto) > 0))
			{
				$bd->budget_iten_insert($proto,$desc,$quan,$valr,$finan);	
			}
		
		if (($dd[12]=='DEL') and (checkpost($dd[0])==$dd[11]))
			{
				$bd->budget_iten_del($dd[0]);
				require("close.php");
			} else {
				echo $bd->budget_list($proto);			
			}
	}
if ($dd[10] == 'crono')
	{
		// Cronograma
		require("_class/_class_budget.php");
		$bd = new budget;
		$dtini = substr($dd[2],2,4).substr($dd[2],0,2);
		$dtfim = substr($dd[3],2,4).substr($dd[3],0,2);

		$desc = $dd[1];
		$proto = $dd[11];
		if (($dtfim > 0) and ($dtini > 0) and (strlen($proto) > 0) and ($dtfim >= $dtini))
			{
				$bd->crono_iten_insert($proto,$desc,$dtini,$dtfim	,$finan);	
			}
		if (($dd[12]=='DEL') and (checkpost($dd[0])==$dd[11]))
			{
				$bd->crono_iten_del($dd[0]);
				require("close.php");
			} else {
				echo $bd->crono_list($proto);			
			}
	}	
?>

