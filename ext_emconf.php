<?php

########################################################################
# Extension Manager/Repository config file for ext: "timtab_technorati"
#
# Auto generated 21-04-2007 18:49
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TIMTAB Technorati',
	'description' => 'Ping technorati and show special technorati tags',
	'category' => 'plugin',
	'author' => 'Michael Feinbier',
	'author_email' => 'typo3@feinbier.net',
	'shy' => '',
	'dependencies' => 'timtab',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_news',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.1',
	'constraints' => array(
		'depends' => array(
			'timtab' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:13:{s:9:"ChangeLog";s:4:"4c7e";s:10:"README.txt";s:4:"ee2d";s:33:"class.tx_timtabtechnorati_lib.php";s:4:"2ae7";s:21:"ext_conf_template.txt";s:4:"3ca1";s:12:"ext_icon.gif";s:4:"96dc";s:17:"ext_localconf.php";s:4:"902f";s:14:"ext_tables.php";s:4:"fdac";s:14:"ext_tables.sql";s:4:"eab5";s:24:"ext_typoscript_setup.txt";s:4:"8182";s:16:"locallang_db.xml";s:4:"f646";s:14:"doc/manual.sxw";s:4:"d628";s:19:"doc/wizard_form.dat";s:4:"c1ab";s:20:"doc/wizard_form.html";s:4:"66e0";}',
	'suggests' => array(
	),
);

?>