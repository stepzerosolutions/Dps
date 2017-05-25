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

use Stepzerosolutions\Dps\Model\Includes\MifMessage;
/**
 * PxPay PxPayResponse Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
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
    private $_mifmessage;

    /**
    * Construct
    *
    * @param MifMessage $mifmessage Message
    *
    * @SuppressWarnings(PHPMD.ExcessiveParameterList)
    */
    public function __construct(
        MifMessage $mifmessage
    ) {
        $this->_mifmessage = $mifmessage;
    }
    
    /**
    * prcessResponse
    *
    * @param object $xml Xml data
    *
    * @return this
    */
    public function prcessResponse($xml)
    {
        $this->_mifmessage->loadMifMessage($xml);
        $this->PxPayMessage();
        $this->Success = $this->_mifmessage->getElementText("Success");
        $this->setTxnType($this->_mifmessage->getElementText("TxnType"));
        $this->CurrencyInput = $this->_mifmessage->getElementText("CurrencyInput");
        $this->setMerchantReference(
            $this->_mifmessage->getElementText("MerchantReference")
        );
        $this->setTxnData1($this->_mifmessage->getElementText("TxnData1"));
        $this->setTxnData2($this->_mifmessage->getElementText("TxnData2"));
        $this->setTxnData3($this->_mifmessage->getElementText("TxnData3"));
        $this->AuthCode = $this->_mifmessage->getElementText("AuthCode");
        $this->CardName = $this->_mifmessage->getElementText("CardName");
        $this->CardHolderName = $this->_mifmessage->getElementText("CardHolderName");
        $this->CardNumber = $this->_mifmessage->getElementText("CardNumber");
        $this->DateExpiry = $this->_mifmessage->getElementText("DateExpiry");
        $this->ClientInfo = $this->_mifmessage->getElementText("ClientInfo");
        $this->TxnId = $this->_mifmessage->getElementText("TxnId");
        $this->setEmailAddress($this->_mifmessage->getElementText("EmailAddress"));
        $this->DpsTxnRef = $this->_mifmessage->getElementText("DpsTxnRef");
        $this->BillingId = $this->_mifmessage->getElementText("BillingId");
        $this->DpsBillingId = $this->_mifmessage->getElementText("DpsBillingId");
        $this->AmountSettlement = $this->_mifmessage->getElementText(
            "AmountSettlement"
        );
        $this->CurrencySettlement = $this->_mifmessage->getElementText(
            "CurrencySettlement"
        );
        $this->TxnMac = $this->_mifmessage->getElementText("TxnMac");
        $this->ResponseText = $this->_mifmessage->getElementText("ResponseText");
        return $this;
    }
    /**
    * getSuccess
    *
    * @return string
    */
    public function getSuccess()
    {
        return $this->Success;
    }
    /**
    * getAuthCode
    *
    * @return string
    */
    public function getAuthCode()
    {
        return $this->AuthCode;
    }
    /**
    * getCardName
    *
    * @return string
    */
    public function getCardName()
    {
        return $this->CardName;
    }
    /**
    * getCardName
    *
    * @return string
    */
    public function getCardHolderName()
    {
        return $this->CardHolderName;
    }
    /**
    * getCardNumber
    *
    * @return string
    */
    public function getCardNumber()
    {
        return $this->CardNumber;
    }
    /**
    * getDateExpiry
    *
    * @return string
    */
    public function getDateExpiry()
    {
        return $this->DateExpiry;
    }
    /**
    * getClientInfo
    *
    * @return string
    */
    public function getClientInfo()
    {
        return $this->ClientInfo;
    }
    /**
    * getDpsTxnRef
    *
    * @return string
    */
    public function getDpsTxnRef()
    {
        return $this->DpsTxnRef;
    }
    /**
    * getDpsBillingId
    *
    * @return string
    */
    public function getDpsBillingId()
    {
        return $this->DpsBillingId;
    }
    /**
    * getAmountSettlement
    *
    * @return string
    */
    public function getAmountSettlement()
    {
        return $this->AmountSettlement;
    }
    /**
    * getCurrencySettlement
    *
    * @return string
    */
    public function getCurrencySettlement()
    {
        $this->CurrencySettlement;
    }
    /**
    * getTxnMac
    *
    * @return string
    */
    public function getTxnMac()
    {
        return $this->TxnMac;
    }
    /**
    * getResponseText
    *
    * @return string
    */
    public function getResponseText()
    {
        return $this->ResponseText;
    }
    /**
    * getCurrencyInput
    *
    * @return string
    */
    public function getCurrencyInput()
    {
        return $this->CurrencyInput;
    }
}