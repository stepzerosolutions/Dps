<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Source Model class
 *
 * PHP version 7
 *
 * @category Module
 * @package  Dps
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 *
 * @link     http://stepzero.solutions
 */
namespace Stepzerosolutions\Dps\Model\Includes;
/**
 * PxPay PxPayMessage Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
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

    /**
    * PxPayMessage
    */
    public function PxPayMessage()
    {
    }
    
    /**
    * SetBillingId
    *
    * @param string $billingId Billingid
    *
    * @return void
    */
    public function setBillingId($billingId)
    {
        $this->BillingId = $billingId;
    }

    /**
    * GetBillingId
    *
    * @return string
    */
    public function getBillingId()
    {
        return $this->BillingId;
    }
    
    /**
    * setTxnType
    *
    * @param string $txnType Type
    *
    * @return void
    */
    public function setTxnType($txnType)
    {
        $this->TxnType = $txnType;
    }
    
    /**
    * GetTxnType
    *
    * @return string
    */
    public function getTxnType()
    {
        return $this->TxnType;
    }
    
    /**
    * SetCurrencyInput
    *
    * @param string $currencyInput CurrencyInput
    *
    * @return void
    */
    public function setCurrencyInput($currencyInput)
    {
        $this->CurrencyInput = $currencyInput;
    }
    
    /**
    * GetCurrencyInput
    *
    * @return string
    */
    public function getCurrencyInput()
    {
        return $this->CurrencyInput;
    }
    
    /**
    * setMerchantReference
    *
    * @param string $merchantReference Merchant Reference
    *
    * @return void
    */
    public function setMerchantReference($merchantReference)
    {
        $this->MerchantReference = $merchantReference;
    }
    
    /**
    * getMerchantReference
    *
    * @return string
    */
    public function getMerchantReference()
    {
        return $this->MerchantReference;
    }
    
    /**
    * setEmailAddress
    *
    * @param string $EmailAddress Email
    *
    * @return void
    */
    public function setEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }
    
    /**
    * getMerchantReference
    *
    * @return string
    */
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }
    
    /**
    * setTxnData1
    *
    * @param string $TxnData1 Txn
    *
    * @return void
    */
    public function setTxnData1($TxnData1)
    {
        $this->TxnData1 = $TxnData1;
    }
    
    /**
    * getTxnData1
    *
    * @return string
    */
    public function getTxnData1()
    {
        return $this->TxnData1;
    }

    /**
    * SetTxnData2
    *
    * @param string $TxnData2 Txn
    *
    * @return void
    */
    public function setTxnData2($TxnData2)
    {
        $this->TxnData2 = $TxnData2;
    }
    
    /**
    * getTxnData2
    *
    * @return string
    */
    public function getTxnData2()
    {
        return $this->TxnData2;
    }
    
    /**
    * getTxnData3
    *
    * @return string
    */
    public function getTxnData3()
    {
        return $this->TxnData3;
    }
    
    /**
    * setTxnData3
    *
    * @param string $TxnData3 Txn
    *
    * @return void
    */
    public function setTxnData3($TxnData3)
    {
        $this->TxnData3 = $TxnData3;
    }

    /**
    * setTxnId
    *
    * @param string $TxnId Txn
    *
    * @return void
    */
    public function setTxnId($TxnId)
    {
        $this->TxnId = $TxnId;
    }

    /**
    * getTxnId
    *
    * @return string
    */
    public function getTxnId()
    {
        return $this->TxnId;
    }

    /**
    * toXml
    *
    * @return object
    */
    public function toXml()
    {
        $arr = get_object_vars($this);
        $xml  = "<GenerateRequest>";
        while (list($prop, $val) = each($arr)) {
            $xml .= "<$prop>$val</$prop>";
        }
        $xml .= "</GenerateRequest>";
        return $xml;
    }
}