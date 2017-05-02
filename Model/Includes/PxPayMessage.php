<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Includes;
/**
 * DPS PxPay Magento 2 Module
 * Abstract base class for PxPay messages.
 * These are messages with certain defined elements,  which can be serialized to XML.
 */

 
class PxPayMessage
{
	protected $TxnType;
	protected $CurrencyInput;
  	protected $TxnData1;
  	protected $TxnData2;
  	protected $TxnData3;
  	protected $MerchantReference;
  	protected $EmailAddress;
  	protected $BillingId;
	protected $TxnId;
	
	public function PxPayMessage(){
	
	}

	public function setBillingId($BillingId){
		$this->BillingId = $BillingId;
	}
	public function getBillingId(){
		return $this->BillingId;
	}
	public function setTxnType($TxnType){
		$this->TxnType = $TxnType;
	}
	public function getTxnType(){
		return $this->TxnType;
	}
	public function setCurrencyInput($CurrencyInput){
		$this->CurrencyInput = $CurrencyInput;
	}
	public function getCurrencyInput(){
		return $this->CurrencyInput;
	}
	public function setMerchantReference($MerchantReference){
		$this->MerchantReference = $MerchantReference;
	}
	public function getMerchantReference(){
		return $this->MerchantReference;
	}
	public function setEmailAddress($EmailAddress){
		$this->EmailAddress = $EmailAddress;
	}
	public function getEmailAddress(){
		return $this->EmailAddress;
	}
	public function setTxnData1($TxnData1){
		$this->TxnData1 = $TxnData1;
	}
	public function getTxnData1(){
		return $this->TxnData1;
	}
	public function setTxnData2($TxnData2){
		$this->TxnData2 = $TxnData2;
	}
	public function getTxnData2(){
		return $this->TxnData2;
	}
	public function getTxnData3(){
		return $this->TxnData3;
	}
	public function setTxnData3($TxnData3){
		$this->TxnData3 = $TxnData3;
	}
	public function setTxnId( $TxnId)
	{
		$this->TxnId = $TxnId;
	}
	public function getTxnId(){
		return $this->TxnId;
	}
	
	public function toXml(){
		$arr = get_object_vars($this);

		$xml  = "<GenerateRequest>";
    	while (list($prop, $val) = each($arr))
        	$xml .= "<$prop>$val</$prop>" ;

		$xml .= "</GenerateRequest>";
		return $xml;
	}
	
	
}
