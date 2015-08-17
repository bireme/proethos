<?php
/**
 * XML OMS
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.12.07
 * @package Class
 * @subpackage oms
 */
class oms {
	function showxml($xml) {

	}

	function icone($id = '') {
		$sx .= '<div id="xml_oms">';
		$sx .= '<div id="xml_oms_right">';
		$sx .= 'OMS';
		$sx .= '</div>';
		$sx .= '<div id="xml_oms_left">';
		$sx .= 'XML';
		$sx .= '</div>';
		$sx .= '</div>';

		$sx .= '<script>' . chr(13);
		$sx .= '$("#xml_oms").click(function() {
							newxy2(\'oms_xml.php?dd0=' . $id . '&dd90=' . checkpost($id) . '\',600,400);
					});' . chr(13);
		$sx .= '</script>' . chr(13);
		return ($sx);
	}

	function xml($cep) {
		$title = htmlspecialchars($cep -> line['cep_titulo']);
		$titlep = htmlspecialchars($cep -> line['cep_titulo_public']);
		/* data */
		$data = $cep -> line['cep_data'];
		$data = substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2) . 'T00:00:00';
		//print_r($cep);
		$xml = "
<trials>
	<trial>
		<main>
			<trial_id></trial_id> 
			<utrn /> 
			<reg_name>RPEC</reg_name> 
			<date_registration>**DATA**</date_registration> 
			<primary_sponsor>**AUTOR**</primary_sponsor> 
  			<public_title>$titlep</public_title>
			<acronym /> 
  			<scientific_title>$title</scientific_title> 
  			<scientific_acronym>$acronym</scientific_acronym> 
  			<date_enrolment>$data</date_enrolment> 
  			<type_enrolment /> 
  			<target_size>**tabg**</target_size> 
  			<recruitment_status /> 
  			<url>SITE</url> 
  			<study_type /> 
  			<study_design>**Desenho**</study_design> 
  			<phase>**FASE**</phase> 
  			<hc_freetext>**</hc_freetext> 
  			<i_freetext>**FREE TEXT**</i_freetext> 
		</main>
		<contacts>
			<contact>
  				<tipo>public</tipo> 
  				<firstname>***</firstname> 
  				<middlename>**</middlename> 
  				<lastname>***</lastname> 
  				<address>****</address> 
  				<city>***</city> 
  				<country1>***</country1> 
  				<zip /> 
  				<telephone>*****</telephone> 
  				<email>*****</email> 
  				<affiliation>****</affiliation> 
  			</contact>
			<contact>
  				<tipo>public</tipo> 
  				<nombres>**</nombres> 
  				<apell_mat>****</apell_mat> 
  				<apell_pat>****</apell_pat> 
  				<direccion>****</direccion> 
  				<distrito>*****</distrito> 
  				<provincia>****</provincia> 
  				<departamento>*****</departamento> 
  				<ruc>*****</ruc> 
  			  	<mail>****</mail> 
  				<ejecutor>*****</ejecutor> 
  			</contact>
  		</contacts>
		<country>
  			<country2>***</country2> 
  			<country2>****</country2> 
  			<country2>****</country2> 
  		</country>
		<criteria>
  			<inclusion_criteria>***</inclusion_criteria> 
  			<agemin>18</agemin> 
  			<agemax>99</agemax> 
  			<gender>-</gender> 
  			<exclusion_criteria>
  			****
  			</exclusion_criteria> 
  		</criteria>
			<hc_keyword>
  				<hc_code /> 
  			</hc_keyword>
		<health_condition_keyword>
  			<hc_code /> 
  		</health_condition_keyword>
		<i_keyword>
  			<i_code /> 
  		</i_keyword>
		<intervention_keyword>
  			<hc_code /> 
  		</intervention_keyword>
		<primary_outcome>
  			<prim_outcome>â¢Overall survival [ Time Frame: approximately 8 years ] [ Designated as safety issue: No ] NAME OF THE RESULT: Overall survival USED MEASURING METHOD :The Kaplan-Meier method will be used to calculate the median OS for each treatment arm. The log-rank test bilateral, stratified by measurable disease versus non-measurable / evaluable, geographic region (U.S. vs. outside the U.S.) and creatinine clearance (45-59 mL / min vs> 60 mL / min), will be used to compare OS between the two treatment arms of trastuzumab. Also provide the result of the Log-Rank test unstratified. The stratified Cox regression (with proportional hazards) will also be used to estimate hazard ratios and to calculate confidence intervals 95% (95% CI) of risk indices. PERIOD OF TIME WHERE THE MEASUREMENT WILL BE CONDUCTED AND WHICH WILL ALLOW OBTAINING THE PRIMARY RESULT: 8 years</prim_outcome> 
  		</primary_outcome>
		<secondary_outcome>
  			<sec_outcome>Progression Free Survival NAME OF THE RESULT: Progression Free Survival USED MEASURING METHOD :The Kaplan-Meier method The log-rank test bilateral PERIOD OF TIME WHERE THE MEASUREMENT WILL BE CONDUCTED AND WHICH WILL ALLOW OBTAINING THE SECONDARY RESULT: 6 months</sec_outcome> 
  		</secondary_outcome>
		<secondary_ids>
			<secondary_id>
	  			<sec_id>BO27798</sec_id> 
  				<issuing_authority /> 
  			</secondary_id>
  		</secondary_ids>
		<secondary_sponsor>
  			<sponsor_name /> 
  		</secondary_sponsor>
		<source_support>
  			<source_name>F. HOFFMANN-LA ROCHE LTD.</source_name> 
  		</source_support>
  	</trial>
</trials>";
		$xml = troca($xml, '&amp;', '[XXX]');
		//$xml = troca($xml,'<','&lt;');
		//$xml = troca($xml,'>','&gt;');
		$xml = troca($xml, '&', '&amp;');
		$xml = troca($xml, '[XXX]', '&amp;');
		return ($xml);
	}

}
