CREATE TABLE ajax_pais (
  id_pais serial NOT NULL,
  pais_nome char(30) DEFAULT NULL,
  pais_codigo char(7) DEFAULT NULL,
  pais_ativo int(11) DEFAULT '1',
  pais_use char(7) DEFAULT NULL,
  pais_idioma char(5) DEFAULT NULL
) ;


CREATE TABLE apoio_idioma (
  id_i serial NOT NULL,
  i_codigo char(5) NOT NULL,
  i_nome char(20) NOT NULL,
  i_ativo int(1) NOT NULL
) ;

CREATE TABLE apoio_titulacao (
  id_ap_tit serial NOT NULL,
  ap_tit_codigo char(7) DEFAULT NULL,
  ap_tit_titulo char(20) DEFAULT NULL,
  ap_tit_idioma char(5) DEFAULT 'pt_BR',
  at_tit_ativo int(11) DEFAULT '1',
  ap_ordem int(11) DEFAULT '0'
) ;

CREATE TABLE calender (
  id_cal serial NOT NULL,
  cal_date int(11) DEFAULT NULL,
  cal_time char(5) DEFAULT NULL,
  cal_cod char(3) DEFAULT NULL,
  cal_description char(80) DEFAULT NULL,
  cal_ativo int(11) DEFAULT NULL,
  cal_public char(1) NOT NULL
) ;

CREATE TABLE calender_type (
  id_calt serial NOT NULL,
  calt_codigo char(3) DEFAULT NULL,
  calt_descricao char(80) DEFAULT NULL,
  calt_ativo int(11) DEFAULT NULL,
  calt_color char(7) NOT NULL
) ;

CREATE TABLE cep_action (
  id_action serial NOT NULL,
  action_status char(1) NOT NULL,
  action_descricao char(100) NOT NULL,
  action_caption char(30) NOT NULL,
  action_ativa int(11) NOT NULL,
  action_code char(3) NOT NULL,
  action_color char(7) NOT NULL
) ;

CREATE TABLE cep_action_permission (
  id_actionp serial NOT NULL,
  actionp_action char(3) NOT NULL,
  actionp_perfil char(4) NOT NULL,
  actionp_ativa int(11) NOT NULL
) ;

CREATE TABLE cep_amendment_type (
  id_amt serial NOT NULL,
  amt_codigo char(3) NOT NULL,
  amt_descrip char(100) NOT NULL,
  amt_ativo int(11) NOT NULL,
  amt_form char(5) NOT NULL,
  amt_ord int(11) NOT NULL
) ;

CREATE TABLE cep_comment (
  id_cepc serial NOT NULL,
  cepc_codigo char(7) DEFAULT NULL,
  cepc_user char(8) DEFAULT NULL,
  cepc_comment text,
  cepc_data bigint(20) DEFAULT NULL,
  cepc_hora char(8) DEFAULT NULL,
  cepc_avaliation char(1) DEFAULT NULL
) ;

CREATE TABLE cep_email (
  id_email int(11) NOT NULL,
  email_research char(8) NOT NULL,
  email_data int(11) NOT NULL,
  email_hora char(8) NOT NULL,
  email_assunto char(100) NOT NULL,
  email_texto text NOT NULL,
  email_protocolo char(10) NOT NULL,
  email_status char(1) NOT NULL,
  email_log char(8) NOT NULL,
  email_id_msg char(8) NOT NULL,
  email_read char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE cep_ged_documento (
  id_doc serial NOT NULL,
  doc_dd0 char(7) DEFAULT NULL,
  doc_tipo char(5) DEFAULT NULL,
  doc_ano char(4) DEFAULT NULL,
  doc_filename text,
  doc_status char(1) DEFAULT NULL,
  doc_data int(11) DEFAULT NULL,
  doc_hora char(5) DEFAULT NULL,
  doc_arquivo text,
  doc_extensao char(4) DEFAULT NULL,
  doc_size double DEFAULT NULL,
  doc_ativo int(11) DEFAULT NULL,
  doc_versao char(2) NOT NULL
) ;


CREATE TABLE cep_ged_documento_tipo (
  id_doct serial NOT NULL,
  doct_nome char(50) DEFAULT NULL,
  doct_codigo char(5) DEFAULT NULL,
  doct_publico int(11) DEFAULT NULL,
  doct_avaliador int(11) DEFAULT NULL,
  doct_autor int(11) DEFAULT NULL,
  doct_restrito int(11) DEFAULT NULL,
  doct_ativo int(11) DEFAULT NULL
) ;

CREATE TABLE cep_parecer (
  id_pr serial NOT NULL,
  pr_protocol char(15) NOT NULL,
  pr_versao int(15) NOT NULL,
  pr_situacao char(3) NOT NULL,
  pr_status char(1) NOT NULL,
  pr_texto_1 text NOT NULL,
  pr_texto_2 text NOT NULL,
  pr_texto_3 text NOT NULL,
  pr_texto_4 text NOT NULL,
  pr_texto_5 text NOT NULL,
  pr_texto_6 text NOT NULL,
  pr_texto_7 text NOT NULL,
  pr_texto_8 text NOT NULL,
  pr_texto_9 text NOT NULL,
  pr_relator char(7) NOT NULL,
  pr_revisor char(7) NOT NULL,
  pr_data int(11) NOT NULL,
  pr_hora char(8) NOT NULL,
  pr_log char(7) NOT NULL,
  pr_ativo int(11) NOT NULL,
  pr_data_emissao int(11) NOT NULL,
  pr_ass char(7) NOT NULL,
  pr_accompaniment int(11) NOT NULL
) ;


CREATE TABLE cep_protocolos (
  id_cep serial NOT NULL,
  cep_codigo char(7) DEFAULT NULL,
  cep_tipo char(3) DEFAULT NULL,
  cep_protocol char(15) DEFAULT NULL,
  cep_fr char(15) DEFAULT NULL,
  cep_versao char(15) DEFAULT NULL,
  cep_data bigint(20) DEFAULT NULL,
  cep_hora char(5) DEFAULT NULL,
  cep_resumo text,
  cep_study_type text NOT NULL,
  cep_goal text NOT NULL,
  cep_pesquisador char(7) DEFAULT NULL,
  cep_local_realizacao char(120) DEFAULT NULL,
  cep_status char(1) DEFAULT NULL,
  cep_ata char(10) DEFAULT NULL,
  cep_dt_parecer bigint(20) DEFAULT NULL,
  cep_titulacao char(10) DEFAULT NULL,
  cep_grupo char(4) DEFAULT NULL,
  cep_titulo text,
  cep_titulo_public text NOT NULL,
  cep_conhecimento char(100) DEFAULT NULL,
  cep_caae char(30) DEFAULT NULL,
  cep_atualizado bigint(20) DEFAULT '19000101',
  cep_atual char(7) DEFAULT NULL,
  cep_relator char(7) DEFAULT NULL,
  cep_reuniao bigint(20) DEFAULT NULL,
  cep_st_parecer char(1) DEFAULT NULL,
  cep_nr_parecer char(7) DEFAULT NULL,
  cep_revisor char(7) DEFAULT NULL,
  cep_atual_revisor char(7) DEFAULT NULL,
  cep_submit char(7) DEFAULT NULL,
  cep_dt_ciencia bigint(20) DEFAULT '0',
  cep_dt_liberacao bigint(20) DEFAULT '0',
  cep_sinte text,
  cep_comment_pos int(11) NOT NULL,
  cep_comment_neg int(11) NOT NULL,
  cep_dictamen int(11) NOT NULL,
  cep_approved int(11) NOT NULL,
  cep_clinic char(1) NOT NULL,
  cep_xml text NOT NULL,
  cep_recrutamento int(11) NOT NULL,
  cep_monitoring int(11) NOT NULL,
  cep_aproved int(11) NOT NULL
) ;

CREATE TABLE cep_protocolos_historic (
  id_his serial NOT NULL,
  his_protocol char(15) NOT NULL,
  his_codigo char(3) NOT NULL,
  his_data int(11) NOT NULL,
  his_time char(8) NOT NULL,
  his_comment char(100) NOT NULL,
  his_log char(8) NOT NULL,
  his_caae char(15) NOT NULL
) ;

CREATE TABLE cep_protocol_log (
  id_cl serial NOT NULL,
  cl_data int(11) NOT NULL,
  cl_hora char(8) NOT NULL,
  cl_protocol char(8) NOT NULL,
  cl_cod char(20) NOT NULL
) ;


CREATE TABLE cep_status (
  id_ess serial NOT NULL,
  ess_status char(1) DEFAULT NULL,
  ess_codigo char(5) DEFAULT NULL,
  ess_encaminhar char(7) DEFAULT NULL,
  ess_acompanha char(7) DEFAULT NULL,
  ess_status_mst char(1) DEFAULT NULL,
  ess_descricao_1 char(60) DEFAULT NULL,
  ess_descricao_2 char(60) DEFAULT NULL,
  ess_descricao_3 char(60) DEFAULT NULL,
  ess_descricao_4 char(60) DEFAULT NULL,
  ess_descricao_5 text,
  ess_journal_id bigint(20) DEFAULT '1',
  ess_prazo bigint(20) DEFAULT '0',
  ess_limpa_atual bigint(20) DEFAULT '0',
  ess_atualiza_prazo bigint(20) DEFAULT '0',
  ess_status_1 char(1) DEFAULT NULL,
  ess_status_2 char(1) DEFAULT NULL,
  ess_status_3 char(1) DEFAULT NULL,
  ess_status_4 char(1) DEFAULT NULL,
  ess_limpa_parecerista_1 bigint(20) DEFAULT NULL,
  ess_limpa_parecerista_2 bigint(20) DEFAULT NULL,
  ess_limpa_revisor bigint(20) DEFAULT NULL,
  ess_limpa_normalizador bigint(20) DEFAULT NULL,
  ess_limpa_editor bigint(20) DEFAULT NULL,
  ess_limpa_diagramador bigint(20) DEFAULT NULL,
  ess_limpa_secretaria bigint(20) DEFAULT NULL,
  ess_ativo bigint(20) DEFAULT '1',
  ess_limpa_geral bigint(20) DEFAULT '0',
  ess_nucleo char(10) NOT NULL
) ;


CREATE TABLE cep_submit_country (
  id_ctr serial NOT NULL,
  ctr_protocol char(7) NOT NULL,
  ctr_country char(5) NOT NULL,
  ctr_ativo int(11) NOT NULL,
  ctr_target int(11) NOT NULL
) ;

CREATE TABLE cep_submit_crono (
  id_scrono serial NOT NULL,
  scrono_descricao char(100) NOT NULL,
  scrono_date_start int(11) NOT NULL,
  scrono_date_end int(11) NOT NULL,
  scrono_protocol char(7) NOT NULL,
  scrono_ativo int(11) NOT NULL
) ;

CREATE TABLE cep_submit_documento (
  id_doc serial NOT NULL,
  doc_1_titulo text,
  doc_1_titulo_public text NOT NULL,
  doc_protocolo char(7) DEFAULT NULL,
  doc_tipo char(5) NOT NULL,
  doc_human int(11) NOT NULL,
  doc_clinic int(11) NOT NULL,
  doc_data int(11) DEFAULT '0',
  doc_hora char(8) DEFAULT NULL,
  doc_dt_atualizado int(11) DEFAULT '19000101',
  doc_autor_principal char(7) DEFAULT NULL,
  doc_research_main char(8) NOT NULL,
  doc_status char(7) DEFAULT NULL,
  doc_xml text NOT NULL,
  doc_type char(3) NOT NULL,
  doc_caae char(20) NOT NULL
) ;


CREATE TABLE cep_submit_documentos_obrigatorio (
  id_sdo serial NOT NULL,
  sdo_codigo char(7) DEFAULT NULL,
  sdo_descricao char(50) DEFAULT NULL,
  sdo_content text,
  sdo_info text,
  sdo_ativo int(11) DEFAULT '1',
  sdo_obrigatorio int(11) DEFAULT '0',
  sdo_tipo char(5) DEFAULT NULL,
  sdo_upload int(11) DEFAULT '0',
  sdo_modelo char(100) DEFAULT NULL,
  sdo_ordem int(11) DEFAULT '0'
) ;


CREATE TABLE cep_submit_documento_valor (
  id_spc serial NOT NULL,
  spc_codigo char(7) DEFAULT NULL,
  spc_projeto char(7) DEFAULT NULL,
  spc_content text,
  spc_ativo int(11) DEFAULT '1',
  spc_pagina char(3) DEFAULT NULL,
  spc_autor char(7) DEFAULT NULL
) ;




CREATE TABLE cep_submit_ged_files (
  id_pl serial NOT NULL,
  pl_type char(3) DEFAULT NULL,
  pl_filename char(255) DEFAULT NULL,
  pl_texto text,
  pl_texto_sql text,
  pl_size bigint(20) DEFAULT NULL,
  pl_data bigint(20) DEFAULT NULL,
  pl_hora char(5) DEFAULT NULL,
  pl_versao bigint(20) DEFAULT '1',
  pl_acesso bigint(20) DEFAULT '0',
  pl_codigo char(7) DEFAULT NULL,
  pl_tp_doc char(7) DEFAULT NULL,
  pl_tp_projeto char(7) DEFAULT NULL,
  pl_post char(7) DEFAULT NULL,
  pl_autor char(7) DEFAULT NULL,
  user_id bigint(20) DEFAULT NULL
)  ;

CREATE TABLE cep_submit_grupos (
  id_sg serial NOT NULL,
  sg_descricao char(100) NOT NULL,
  sg_participantes int(11) NOT NULL,
  sg_centro int(11) NOT NULL,
  sg_outros int(11) NOT NULL,
  sg_internacional int(11) NOT NULL,
  sg_criterio_inclusao text NOT NULL,
  sg_criterio_exclusao text NOT NULL,
  sg_riscos text NOT NULL,
  sg_intervencao text NOT NULL,
  sg_protocolo char(7) NOT NULL,
  sg_ativo int(11) NOT NULL,
  sg_data int(11) NOT NULL,
  sg_grupo int(11) NOT NULL
) ;


CREATE TABLE cep_submit_institution_dados (
  id_sid serial NOT NULL,
  sid_institution char(7) NOT NULL,
  sid_protocol char(7) NOT NULL,
  sid_field char(7) NOT NULL,
  sid_update int(11) NOT NULL
) ;

CREATE TABLE cep_submit_manuscrito_field (
  id_sub serial NOT NULL,
  sub_pos int(11) DEFAULT '0',
  sub_field text,
  sub_css text,
  sub_descricao char(80) DEFAULT NULL,
  sub_ativo int(11) DEFAULT '1',
  sub_codigo char(5) DEFAULT NULL,
  sub_pag char(5) DEFAULT NULL,
  sub_obrigatorio int(11) DEFAULT '0',
  sub_editavel int(11) DEFAULT '1',
  sub_informacao text,
  sub_projeto_tipo char(5) DEFAULT NULL,
  sub_ordem int(11) DEFAULT '0',
  sub_pdf_title char(60) DEFAULT NULL,
  sub_pdf_mostra int(11) DEFAULT '0',
  sub_pdf_align char(10) DEFAULT NULL,
  sub_pdf_font_size int(11) DEFAULT '12',
  sub_pdf_space int(11) DEFAULT '8',
  sub_limite char(7) DEFAULT NULL,
  sub_caption text,
  sub_id char(7) DEFAULT NULL
) ;



CREATE TABLE cep_submit_manuscrito_tipo (
  id_sp serial NOT NULL,
  sp_codigo char(5) DEFAULT NULL,
  sp_descricao char(50) DEFAULT NULL,
  sp_ordem int(11) DEFAULT '0',
  sp_content text,
  sp_ativo int(11) DEFAULT '1',
  sp_nucleo char(7) DEFAULT NULL,
  sp_caption text
) ;

CREATE TABLE cep_submit_orca (
  id_sorca serial NOT NULL,
  sorca_descricao char(100) NOT NULL,
  sorca_unid int(11) NOT NULL,
  sorca_valor float NOT NULL,
  sorca_protocol char(7) NOT NULL,
  sorca_ativo int(11) NOT NULL,
  sorca_finan char(7) NOT NULL
) ;

CREATE TABLE cep_submit_register_unit (
  id_csru serial NOT NULL,
  csru_protocolo int(11) NOT NULL,
  csru_unit char(5) NOT NULL,
  csru_number char(20) NOT NULL,
  csru_ativo int(11) NOT NULL,
  csru_data char(20) NOT NULL
) ;

CREATE TABLE cep_submit_team (
  id_ct serial NOT NULL,
  ct_protocol char(7) NOT NULL,
  ct_author char(7) NOT NULL,
  ct_type char(1) NOT NULL,
  ct_data int(11) NOT NULL,
  ct_ativo int(11) NOT NULL

) ;

CREATE TABLE cep_submit_tipo (
  id_sp serial NOT NULL,
  sp_codigo char(5) DEFAULT NULL,
  sp_descricao char(50) DEFAULT NULL,
  sp_ordem int(11) DEFAULT '0',
  sp_content text,
  sp_ativo int(11) DEFAULT '1',
  sp_nucleo char(7) DEFAULT NULL,
  sp_caption text,
  sp_cab_number int(15) NOT NULL
) ;

CREATE TABLE cep_submit_valor (
  id_spc serial NOT NULL,
  spc_codigo char(7) DEFAULT NULL,
  spc_projeto char(7) DEFAULT NULL,
  spc_content text,
  spc_ativo int(11) DEFAULT '1',
  spc_pagina char(3) DEFAULT NULL,
  spc_autor char(7) DEFAULT NULL
) ;

CREATE TABLE cep_survey (
  id_sr serial NOT NULL,
  sr_protocolo char(8) NOT NULL,
  sr_member char(8) NOT NULL,
  sr_yes int(11) NOT NULL,
  sr_no int(11) NOT NULL,
  sr_date int(11) NOT NULL,
  sr_time char(8) NOT NULL,
  sr_ip char(15) NOT NULL
) ;

CREATE TABLE cep_team (
  id_ct serial NOT NULL,
  ct_protocol char(7) NOT NULL,
  ct_author char(7) NOT NULL,
  ct_type char(1) NOT NULL,
  ct_data int(11) NOT NULL,
  ct_ativo int(11) NOT NULL
) ;

CREATE TABLE discentes (
  id_pa serial NOT NULL,
  pa_nome char(100) DEFAULT NULL,
  pa_nome_asc char(100) DEFAULT NULL,
  pa_nasc char(10) DEFAULT NULL,
  pa_codigo char(7) DEFAULT NULL,
  pa_cracha char(15) DEFAULT NULL,
  pa_login char(30) DEFAULT NULL,
  pa_escolaridade char(20) DEFAULT NULL,
  pa_titulacao char(5) DEFAULT NULL,
  pa_carga_semanal int(11) DEFAULT '0',
  pa_ss char(1) DEFAULT NULL,
  pa_cpf char(20) DEFAULT NULL,
  pa_negocio char(30) DEFAULT NULL,
  pa_centro char(100) DEFAULT NULL,
  pa_curso char(100) DEFAULT NULL,
  pa_telefone char(35) DEFAULT NULL,
  pa_celular char(35) DEFAULT NULL,
  pa_tel1 char(35) DEFAULT NULL,
  pa_tel2 char(35) DEFAULT NULL,
  pa_lattes char(100) DEFAULT NULL,
  pa_email char(100) DEFAULT NULL,
  pa_email_1 char(100) DEFAULT NULL,
  pa_senha char(20) DEFAULT NULL,
  pa_endereco text,
  pa_afiliacao char(7) DEFAULT NULL,
  pa_ativo int(11) DEFAULT '1',
  pa_update int(11) DEFAULT '19000101',
  pa_cc_banco char(5) DEFAULT NULL,
  pa_cc_agencia char(6) DEFAULT NULL,
  pa_cc_conta char(15) DEFAULT NULL,
  pa_cc_tipo char(1) DEFAULT NULL,
  pa_obs text,
  pa_bolsa_anterior char(1) DEFAULT NULL,
  pa_bolsa char(1) DEFAULT NULL,
  pa_rg char(20) DEFAULT NULL,
  pa_pai char(100) DEFAULT NULL,
  pa_mae char(100) DEFAULT NULL,
  pa_cep char(10) DEFAULT NULL,
  pa_periodo char(20) DEFAULT NULL,
  pa_ass char(100) DEFAULT NULL,
  pa_img_rg char(100) DEFAULT NULL,
  pa_img_cpf char(100) DEFAULT NULL,
  pa_img_residencia char(100) DEFAULT NULL,
  pa_bairro char(20) DEFAULT NULL,
  pa_cidade char(20) DEFAULT NULL,
  pa_estado char(2) DEFAULT NULL,
  pa_motivo char(3) DEFAULT NULL
) ;

CREATE TABLE docentes (
  id_pp serial NOT NULL,
  pp_nome char(100) DEFAULT NULL,
  pp_nome_asc char(100) DEFAULT NULL,
  pp_nasc char(10) DEFAULT NULL,
  pp_codigo char(7) DEFAULT NULL,
  pp_cracha char(15) DEFAULT NULL,
  pp_login char(30) DEFAULT NULL,
  pp_escolaridade char(20) DEFAULT NULL,
  pp_titulacao char(5) DEFAULT NULL,
  pp_carga_semanal int(11) DEFAULT '0',
  pp_ss char(1) DEFAULT NULL,
  pp_cpf char(20) DEFAULT NULL,
  pp_negocio char(30) DEFAULT NULL,
  pp_centro char(50) DEFAULT NULL,
  pp_curso char(50) DEFAULT NULL,
  pp_telefone char(20) DEFAULT NULL,
  pp_celular char(20) DEFAULT NULL,
  pp_lattes char(100) DEFAULT NULL,
  pp_email char(100) DEFAULT NULL,
  pp_email_1 char(100) DEFAULT NULL,
  pp_senha char(20) DEFAULT NULL,
  pp_endereco text,
  pp_afiliacao char(7) DEFAULT NULL,
  pp_ativo int(11) DEFAULT '1',
  pp_grestudo text,
  pp_prod bigint(20) DEFAULT '0',
  pp_ass char(100) DEFAULT NULL,
  pp_instituicao char(7) NOT NULL
) ;

CREATE TABLE faq (
  id_faq serial NOT NULL,
  faq_pergunta text,
  faq_resposta text,
  faq_ordem int(11) DEFAULT '0',
  faq_ativo int(11) DEFAULT '1',
  faq_seccao char(10) DEFAULT NULL,
  faq_idioma char(5) NOT NULL
) ;

CREATE TABLE frases (
  id_fr serial NOT NULL,
  fr_word char(20) DEFAULT NULL,
  fr_texto text,
  fr_idioma char(5) DEFAULT 'pt_BR',
  journal_id int(11) DEFAULT NULL
)  ;

CREATE TABLE ged_documento (
  id_doc serial NOT NULL,
  doc_dd0 char(7) DEFAULT NULL,
  doc_tipo char(5) DEFAULT NULL,
  doc_ano char(4) DEFAULT NULL,
  doc_filename text,
  doc_status char(1) DEFAULT NULL,
  doc_data int(11) DEFAULT NULL,
  doc_hora char(8) DEFAULT NULL,
  doc_arquivo text,
  doc_extensao char(4) DEFAULT NULL,
  doc_size float DEFAULT NULL,
  doc_ativo int(11) DEFAULT NULL,
  doc_versao char(5) NOT NULL
) ;

CREATE TABLE ged_documento_tipo (
  id_doct serial NOT NULL,
  doct_nome char(50) DEFAULT NULL,
  doct_codigo char(5) DEFAULT NULL,
  doct_publico int(11) DEFAULT NULL,
  doct_avaliador int(11) DEFAULT NULL,
  doct_autor int(11) DEFAULT NULL,
  doct_restrito int(11) DEFAULT NULL,
  doct_ativo int(11) DEFAULT NULL
) ;


CREATE TABLE ic_noticia (
  id_nw serial NOT NULL,
  nw_dt_cadastro bigint(20) DEFAULT NULL,
  nw_secao int(11) DEFAULT NULL,
  nw_link char(120) DEFAULT NULL,
  nw_fonte char(120) DEFAULT NULL,
  nw_titulo char(120) DEFAULT NULL,
  nw_descricao text,
  nw_dt_de bigint(20) DEFAULT NULL,
  nw_dt_ate bigint(20) DEFAULT NULL,
  nw_log char(10) DEFAULT NULL,
  nw_ativo smallint(6) DEFAULT NULL,
  nw_ref char(20) DEFAULT NULL,
  nw_thema char(7) DEFAULT NULL,
  nw_idioma char(5) DEFAULT NULL,
  nw_journal int(11) DEFAULT NULL,
  journal_id int(11) DEFAULT '0'
) ;

CREATE TABLE instituion_action (
  id_ia serial NOT NULL,
  ia_codigo char(5) DEFAULT NULL,
  ia_descricao char(60) DEFAULT NULL,
  ess_ativo bigint(20) DEFAULT '1'
) ;

CREATE TABLE institution (
  id_i serial NOT NULL,
  i_name char(200) NOT NULL,
  i_name_2 char(100) NOT NULL,
  i_name_3 char(100) NOT NULL,
  i_address_1 char(200) NOT NULL,
  i_address_2 char(200) NOT NULL,
  i_address_3 char(200) NOT NULL,
  i_city char(20) NOT NULL,
  i_fone char(20) NOT NULL,
  i_fax char(20) NOT NULL,
  i_email char(100) NOT NULL,
  i_cordenation char(200) NOT NULL,
  i_information text NOT NULL,
  i_system char(5) NOT NULL,
  i_opas_cod char(20) NOT NULL,
  i_date_format char(10) NOT NULL
) ;

CREATE TABLE institutions (
  id_it serial NOT NULL,
  it_codigo char(7) NOT NULL,
  it_nome char(100) NOT NULL,
  it_nome_abrev char(100) NOT NULL,
  it_tipo char(1) NOT NULL,
  it_estrangeiro char(1) NOT NULL,
  it_endereco char(60) NOT NULL,
  it_bairro char(40) NOT NULL,
  it_cidade char(30) NOT NULL,
  it_pais char(7) NOT NULL,
  it_status char(1) NOT NULL,
  it_id_fiscal char(20) NOT NULL,
  it_ativo int(1) NOT NULL,
  it_author char(7) NOT NULL,
  it_abreviatura char(10) NOT NULL,
  it_contato char(30) NOT NULL,
  it_telefone char(15) NOT NULL,
  it_fax char(15) NOT NULL,
  it_email char(70) NOT NULL,
  it_site char(100) NOT NULL,
  it_obs text NOT NULL,
  it_search text NOT NULL
) ;


CREATE TABLE institution_action (
  id_ia serial NOT NULL,
  ia_codigo char(5) DEFAULT NULL,
  ia_descricao char(60) DEFAULT NULL,
  ia_ativo bigint(20) DEFAULT '1'
) ;

CREATE TABLE journals (
  journal_id serial NOT NULL,
  title char(200) DEFAULT NULL,
  description text,
  path char(30) DEFAULT NULL,
  seq bigint(20) DEFAULT NULL,
  enabled smallint(6) DEFAULT NULL,
  layout char(4) DEFAULT NULL,
  journal_issn char(30) DEFAULT NULL,
  jn_bgcor char(8) DEFAULT NULL,
  jn_id char(60) DEFAULT NULL,
  jn_http char(100) DEFAULT NULL,
  jn_email char(100) DEFAULT NULL,
  jn_send char(1) DEFAULT NULL,
  jn_noticia char(1) DEFAULT NULL,
  jn_suplemento char(1) DEFAULT NULL,
  jn_eissn char(15) DEFAULT NULL,
  jn_isbn char(20) DEFAULT NULL,
  jn_title char(100) DEFAULT NULL,
  jn_send_suspense int(11) DEFAULT NULL,
  editor char(150) DEFAULT NULL,
  assinatura text,
  jnl_html_cab text,
  jnl_google char(20) DEFAULT NULL,
  jnl_codidgo char(7) DEFAULT NULL,
  jnl_codigo char(7) DEFAULT NULL,
  jnl_journals_tipo char(3) DEFAULT NULL
) ;

CREATE TABLE nucleo (
  id_n serial NOT NULL,
  n_codigo char(5) NOT NULL,
  n_descricao char(50) NOT NULL,
  n_ativo int(1) NOT NULL
) ;

CREATE TABLE parecer_modelo (
  id_pm serial NOT NULL,
  pm_name char(30) NOT NULL,
  pm_message char(20) NOT NULL,
  pm_type char(3) NOT NULL,
  pm_decision char(3) NOT NULL,
  pm_codigo char(5) NOT NULL,
  pm_approved int(11) NOT NULL,
  pm_0 int(11) NOT NULL,
  pm_1 int(11) NOT NULL,
  pm_2 int(11) NOT NULL,
  pm_3 int(11) NOT NULL,
  pm_4 int(11) NOT NULL,
  pm_5 int(11) NOT NULL,
  pm_6 int(11) NOT NULL,
  pm_7 int(11) NOT NULL,
  pm_8 int(11) NOT NULL,
  pm_accompaniment int(11) NOT NULL
) ;

CREATE TABLE register_unit (
  id_ru serial NOT NULL,
  ru_codigo char(5) NOT NULL,
  ru_name char(80) NOT NULL,
  ru_obs text NOT NULL,
  ru_ativo int(11) NOT NULL,
  ru_type char(1) NOT NULL
) ;

CREATE TABLE submit_manuscrito_field (
  id_sub serial NOT NULL,
  sub_pos int(11) DEFAULT '0',
  sub_field text,
  sub_css text,
  sub_descricao char(80) DEFAULT NULL,
  sub_ativo int(11) DEFAULT '1',
  sub_codigo char(5) DEFAULT NULL,
  sub_pag char(5) DEFAULT NULL,
  sub_obrigatorio int(11) DEFAULT '0',
  sub_editavel int(11) DEFAULT '1',
  sub_informacao text,
  sub_projeto_tipo char(5) DEFAULT NULL,
  sub_ordem int(11) DEFAULT '0',
  sub_pdf_title char(60) DEFAULT NULL,
  sub_pdf_mostra int(11) DEFAULT '0',
  sub_pdf_align char(10) DEFAULT NULL,
  sub_pdf_font_size int(11) DEFAULT '12',
  sub_pdf_space int(11) DEFAULT '8',
  sub_limite char(7) DEFAULT NULL,
  sub_caption text,
  sub_id char(7) DEFAULT NULL
);

CREATE TABLE submit_manuscrito_tipo (
  id_sp serial NOT NULL,
  sp_codigo char(5) DEFAULT NULL,
  sp_descricao char(50) DEFAULT NULL,
  sp_ordem int(11) DEFAULT '0',
  sp_content text,
  sp_ativo int(11) DEFAULT '1',
  sp_nucleo char(7) DEFAULT NULL,
  sp_caption text
) ;

CREATE TABLE usuario (
  id_us serial NOT NULL,
  us_codigo char(7) NOT NULL,
  us_nome char(100) NOT NULL,
  us_login char(100) NOT NULL,
  us_nivel int(11) NOT NULL,
  us_status char(1) NOT NULL,
  us_senha char(40) NOT NULL,
  us_cracha char(8) NOT NULL,
  us_md5 int(11) NOT NULL,
  us_niver int(11) NOT NULL,
  us_ativo int(1) NOT NULL,
  us_email char(100) NOT NULL,
  us_email_alt char(100) NOT NULL,
  us_email_ativo int(11) NOT NULL,
  us_endereco text NOT NULL,
  us_genero char(1) NOT NULL,
  us_instituition char(100) NOT NULL,
  us_empresa char(7) NOT NULL,
  us_country char(7) NOT NULL,
  us_confirmed int(11) NOT NULL,
  us_mother char(100) NOT NULL,
  us_nasc int(11) NOT NULL,
  us_perfil char(30) NOT NULL,
  us_cadastro int(11) NOT NULL
) ;


CREATE TABLE usuario_perfil (
  id_usp serial NOT NULL,
  usp_codigo char(4) NOT NULL,
  usp_descricao char(50) NOT NULL,
  usp_ativo int(1) NOT NULL
)  ;


CREATE TABLE usuario_perfis_ativo (
  id_up serial NOT NULL,
  up_perfil char(4) DEFAULT NULL,
  up_usuario char(7) DEFAULT NULL,
  up_data bigint(20) DEFAULT NULL,
  up_data_end bigint(20) DEFAULT NULL,
  up_ativo bigint(20) DEFAULT NULL
) ;

CREATE TABLE _committee (
  id_cm serial NOT NULL,
  cm_name char(100) NOT NULL,
  cm_site char(150) NOT NULL,
  cm_admin_name char(100) NOT NULL,
  cm_admin_email char(100) NOT NULL,
  cm_committe char(8) NOT NULL,
  cm_admin_key char(40) NOT NULL,
  cm_admin_key_harveting char(40) NOT NULL,
  cm_charcode char(40) NOT NULL,
  cm_address text NOT NULL,
  cm_city char(40) NOT NULL,
  cm_country char(40) NOT NULL,
  cm_phone char(40) NOT NULL,
  cm_type char(4) DEFAULT NULL,
  cm_language char(5) DEFAULT NULL,
  cm_lat char(10) NOT NULL,
  cm_long char(10) NOT NULL
)  ;

CREATE TABLE _messages (
  id_msg serial NOT NULL,
  msg_pag char(50) NOT NULL,
  msg_language char(5) NOT NULL,
  msg_field char(60) NOT NULL,
  msg_content text NOT NULL,
  msg_ativo int(11) NOT NULL,
  msg_update int(11) NOT NULL
) ;
