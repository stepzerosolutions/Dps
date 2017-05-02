<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Includes;
/**
 * DPS PxPay Magento 2 Module
 * Class for PxPay response messages.
 */

 class PxPayResponse extends PxPayMessage
{
	protected $Success;
	protected $AuthCode;
	protected $CardName;
	protected $CardHolderName;	
	protected $CardNumber;
	protected $DateExpiry;
	protected $ClientInfo;
	protected $DpsTxnRef;
  	protected $DpsBillingId;	
	protected $AmountSettlement;
	protected $CurrencySettlement;
	protected $TxnMac;
	protected $ResponseText;
	protected $CurrencyInput;
	protected $_mifmessage;
	
	public function __construct(
		\Stepzerosolutions\Dps\Model\Includes\MifMessage $mifmessage
	){
		$this->_mifmessage = $mifmessage;
	}
	
	public function prcessResponse($xml){
		$this->_mifmessage->loadMifMessage($xml);		
		$this->PxPayMessage();

		$this->Success = $this->_mifmessage->get_element_text("Success");
		$this->setTxnType($this->_mifmessage->get_element_text("TxnType"));	
		$this->CurrencyInput = $this->_mifmessage->get_element_text("CurrencyInput");	
		$this->setMerchantReference($this->_mifmessage->get_element_text("MerchantReference"));	
		$this->setTxnData1($this->_mifmessage->get_element_text("TxnData1"));
		$this->setTxnData2($this->_mifmessage->get_element_text("TxnData2"));
		$this->setTxnData3($this->_mifmessage->get_element_text("TxnData3"));
		$this->AuthCode = $this->_mifmessage->get_element_text("AuthCode");
		$this->CardName = $this->_mifmessage->get_element_text("CardName");		
		$this->CardHolderName = $this->_mifmessage->get_element_text("CardHolderName");	
		$this->CardNumber = $this->_mifmessage->get_element_text("CardNumber");	
		$this->DateExpiry = $this->_mifmessage->get_element_text("DateExpiry");	
		$this->ClientInfo = $this->_mifmessage->get_element_text("ClientInfo");
		$this->TxnId = $this->_mifmessage->get_element_text("TxnId");		
		$this->setEmailAddress($this->_mifmessage->get_element_text("EmailAddress"));
		$this->DpsTxnRef = $this->_mifmessage->get_element_text("DpsTxnRef");		
		$this->BillingId = $this->_mifmessage->get_element_text("BillingId");
		$this->DpsBillingId = $this->_mifmessage->get_element_text("DpsBillingId");
		$this->AmountSettlement = $this->_mifmessage->get_element_text("AmountSettlement");
		$this->CurrencySettlement = $this->_mifmessage->get_element_text("CurrencySettlement");
		$this->TxnMac = $this->_mifmessage->get_element_text("TxnMac");
		$this->ResponseText = $this->_mifmessage->get_element_text("ResponseText");
		return $this;
	}


	public function getSuccess(){
		return $this->Success;
	}
	public function getAuthCode(){
		return $this->AuthCode;
	}
	public function getCardName(){
		return $this->CardName;
	}
	public function getCardHolderName(){
		return $this->CardHolderName;
	}
	public function getCardNumber(){
		return $this->CardNumber;
	}
	public function getDateExpiry(){
		return $this->DateExpiry;
	}
	public function getClientInfo(){
		return $this->ClientInfo;
	}
	public function getDpsTxnRef(){
		return $this->DpsTxnRef;
	}
	public function getDpsBillingId(){
		return $this->DpsBillingId;
	}
	public function getAmountSettlement(){
		return $this->AmountSettlement;
	}	
	public function getCurrencySettlement(){
		$this->CurrencySettlement;
	}
	public function getTxnMac(){
		return $this->TxnMac;
	}
	public function getResponseText(){
		return $this->ResponseText;
	}
	public function getCurrencyInput(){
		return $this->CurrencyInput;
	}
}