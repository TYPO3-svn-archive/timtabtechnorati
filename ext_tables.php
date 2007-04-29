<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_timtabtechnorati_tags" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:timtab_technorati/locallang_db.xml:tt_news.tx_timtabtechnorati_tags",		
		"config" => Array (
			"type" => "input",	
			"size" => "30",
		)
	),
	"tx_timtabtechnorati_response" => Array (		
		"config" => Array (
			"type" => "passthrough",
		)
	),
);

$_EXTCONF	=	unserialize($_EXTCONF);
//only add if own field is not used!
if($_EXTCONF['useKeyword'] != 1) {
	t3lib_div::loadTCA("tt_news");
	t3lib_extMgm::addTCAcolumns("tt_news",$tempColumns,1);
	t3lib_extMgm::addToAllTCAtypes("tt_news","tx_timtabtechnorati_tags;;;;1-1-1, tx_timtabtechnorati_response");
}
?>