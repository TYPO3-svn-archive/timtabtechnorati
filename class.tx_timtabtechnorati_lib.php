<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Michael Feinbier (typo3@feinbier.net)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

# Load xmlrpc and timtab Libs
# includes fix for backwards compatibility
	if(file_exists(t3lib_extMgm::extPath('timtab').'lib.ixr.php' )) {
		# Timtab <= 0.5.8
		require_once( t3lib_extMgm::extPath('timtab').'lib.ixr.php' );
	} else {
		require_once( t3lib_extMgm::extPath('timtab').'3rdparty/lib.ixr.php' );
	}
		
require_once( t3lib_extMgm::extPath('timtab').'class.tx_timtab_be.php' );

require_once(PATH_tslib.'class.tslib_content.php');
/**
 * class.tx_timtabtechnorati_lib.php
 * 
 * This class contains Hooks and functions for sending a ping to 
 * technorati on the given tags.
 *
 * @author	Michael Feinbier <typo3@feinbier.net>
 * @version	$Id$
 */
class tx_timtabtechnorati_lib extends tx_timtab_be {
	
	/** The Extension configuration */
	var	$extConf;
	
	/** The cObj for the FE */
	var	$cObj;
	
	function tx_timtabtechnorati_lib() {
		$this->init();
		$this->extConf	=	unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['timtab_technorati']);
		$this->cObj	=	t3lib_div::makeInstance('tslib_cObj');
	}
	
	/**
	 * After saving/creating a tt_news record ping technorati
	 *
	 * @param unknown_type $status
	 * @param unknown_type $table
	 * @param unknown_type $id
	 * @param unknown_type $fieldArray
	 * @param unknown_type $pObj
	 */
	function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $pObj) {
		$this->preInit($status, $id, $fieldArray, $pObj);
		
		if($this->isBlogPost($id,$fieldArray) && $fieldArray['hidden'] != 1) {
			//ping only if new entry OR datetime&Text is updated (that�s like Wordpress seems to behave)
			if(($fieldArray['bodytext'] && $fieldArray['datetime']) OR $status == 'new') {
				$response	=	$this->pingTechnorati();
				//Upate the response to database
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
					'tt_news',
					'uid = '.$id,
					array('tx_timtabtechnorati_response'	=>	serialize($response))
				);
			}
			
			
		} 
	}
	
	/**
	 * Process an additional Marker in the FE
	 *
	 * @param	array	$markerArray
	 * @param 	array	$row
	 * @param	array	$lConf
	 * @param	object	$pObj
	 */
	function extraItemMarkerProcessor($markerArray, $row, $lConf, &$pObj) {
		//Load Config
		$conf	=	 $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_timtabtechnorati.'];
		$tags	=	$this->getCurrentTags($row['uid']);
		if(is_array($tags) && $tags) {
			foreach($tags AS $tag) {
				$this->cObj->setCurrentVal($tag);
				$string .= $this->cObj->cObjGet($conf['tag.']);	
			}
			$markerArray['###BLOG_TECHNORATI_TAGS###'] =  $this->cObj->wrap(
				$string,$conf['tag.']['wrap']
			);
		} else { $markerArray['###BLOG_TECHNORATI_TAGS###'] = ''; }
		

		return $markerArray;
	}
	
	/**
	 * Returns an array with all selected tags
	 *
	 * @param	integer	the news-record
	 * @return	array
	 */
	function getCurrentTags($uid) {
		//If keyword field is used SELECT keywords FROM .....
		$tableField = ($this->extConf['useKeyword'] == 1) ? 'keywords' : 'tx_timtabtechnorati_tags';
		$data	=	$GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$tableField,'tt_news',
			'uid = '.$uid
		);
		return t3lib_div::trimExplode(',',$data[0][$tableField],1);
	}
	
	/**
	 * Sends the Ping to technorati
	 *
	 * @return	string	Response of technoratis api
	 */
	function pingTechnorati() {
		$xmlrpc	= new IXR_Client('rpc.technorati.com','/rpc/ping');
		$xmlrpc->query('weblogUpdates.ping',
			$this->conf['title'],	//1st Argument: Blog title
			$this->conf['homepage']	//2nd Argument: Blog link
		);
		
		return $xmlrpc->getResponse();
	}
	
	/**
	 * Generates a tag-link. Function is invoked from TypoScript-userFunc
	 *
	 * @param	array	Configuration Array
	 * @return	string	the <a-Element
	 */	
	function user_getTechnoratiLink($url) {
		return '<a href="'.$url['url'].urlencode($this->cObj->getCurrentVal()).
				'" rel="tag" '.$url['aTagParams'].' '.$url['targetParams'].'>';
		
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/timtab_technorati/class.tx_timtabtechnorati_lib.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/timtab_technorati/class.tx_timtabtechnorati_lib.php']);
}
?>