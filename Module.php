<?php
/**
 * This code is licensed under AGPLv3 license or Afterlogic Software License
 * if commercial version of the product was purchased.
 * For full statements of the licenses see LICENSE-AFTERLOGIC and LICENSE-AGPL3 files.
 */

namespace Aurora\Modules\MailBccToSenderPlugin;

/**
 * With this plugin enabled and configured, all email messages sent out will also be delivered to a message sender, regardless of whether the sender's address was supplied in CC / BCC or not.
 * 
 * @license https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0
 * @license https://afterlogic.com/products/common-licensing Afterlogic Software License
 * @copyright Copyright (c) 2019, Afterlogic Corp.
 *
 * @package Modules
 */
class Module extends \Aurora\System\Module\AbstractModule
{
	/**
	 * @param CApiPluginManager $oPluginManager
	 */
	
	public function init() 
	{
		$this->oMailModule = \Aurora\System\Api::GetModule('Mail');
	
		$this->subscribeEvent('Mail::SendMessage::before', array($this, 'onBeforeSendMessage'));
	}
	
	/**
	 * 
	 * @param array $aArguments
	 * @param mixed $mResult
	 */
	public function onBeforeSendMessage(&$aArguments, &$mResult)
	{	
		$oAccount = \Aurora\Modules\Mail\Module::Decorator()->GetAccount($aArguments['AccountID']);
		$aArguments['Bcc'] .= ($aArguments['Bcc']!==''?', ':'') . $oAccount->Email;
	}
}