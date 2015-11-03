<?php
require('cab.php');

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


require('_class/_class_faq.php');

global $acao,$dd,$cp,$tabela;
require($include.'_class_form.php');
$form = new form;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

	$cl = new faq;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
		
	
	$http_edit = $tabela.'_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edicao */
	echo '<CENTER><font class=lt5>'.msg($tabela).'</font></CENTER>';
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina($tabela.'.php');
		} else {
			echo $tela;
		}
echo '</div>';
?>
<script>
	
</script>
<?
echo $hd->foot();
?>

