<?php
    /**
     * Documents
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage documents
    */
class documents
	{
		var $tabela = 'documents_model';
		
		function model_list()
			{
				$sx .= '<Table width="100%" class="table_mode01">';
				$sx .= '<TR><TH width="90%">'.msg('document_name');
				$sx .= '<TH>'.msg('download');
				$sx .= '</table>';
				return($sx);
			}
	}
?>
