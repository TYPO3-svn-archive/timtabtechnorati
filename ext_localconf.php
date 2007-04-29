<?php

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

require_once(t3lib_extMgm::extPath('timtab_technorati').'class.tx_timtabtechnorati_lib.php');

/** Registering Hooks */
$TYPO3_CONF_VARS['EXTCONF']['tt_news']['extraItemMarkerHook'][]        = 'tx_timtabtechnorati_lib';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'tx_timtabtechnorati_lib'; 
?>