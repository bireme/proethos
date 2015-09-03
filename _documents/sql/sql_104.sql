CREATE TABLE IF NOT EXISTS `cep_submit_xml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filepath` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabela responsável por armazenar os XML snapshots da submissão' AUTO_INCREMENT=1 ;
