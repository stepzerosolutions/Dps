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
 * PxPay PxPayRequest Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class PxPayRequest extends PxPayMessage
{
    protected $UrlFail,$UrlSuccess;
    protected $AmountInput;
    protected $EnableAddBillCard;
    protected $PxPayUserId;
    protected $PxPayKey;
    protected $Opt;
    
    /**
    * PxPayRequest
    */
    public function PxPayRequest()
    {
        $this->PxPayMessage();
    }

    /**
    * setEnableAddBillCard
    *
    * @param string $EnableBillAddCard Add Card
    *
    * @return void
    */
    public function setEnableAddBillCard($EnableBillAddCard)
    {
        $this->EnableAddBillCard = $EnableBillAddCard;
    }

    /**
    * setUrlFail
    *
    * @param string $UrlFail Url fail
    *
    * @return void
    */
    public function setUrlFail($UrlFail)
    {
        $this->UrlFail = $UrlFail;
    }

    /**
    * setUrlSuccess
    *
    * @param string $UrlSuccess Url success
    *
    * @return void
    */
    public function setUrlSuccess($UrlSuccess)
    {
        $this->UrlSuccess = $UrlSuccess;
    }

    /**
    * setAmountInput
    *
    * @param string $AmountInput Amount Input
    *
    * @return void
    */
    public function setAmountInput($AmountInput)
    {
        $this->AmountInput = sprintf("%9.2f", $AmountInput);
    }

    /**
    * setUserId
    *
    * @param string $UserId Userid
    *
    * @return void
    */
    public function setUserId($UserId)
    {
        $this->PxPayUserId = $UserId;
    }

    /**
    * setKey
    *
    * @param string $Key Key
    *
    * @return void
    */
    public function setKey($Key)
    {
        $this->PxPayKey = $Key;
    }

    /**
    * setOpt
    *
    * @param string $Opt option
    *
    * @return void
    */
    public function setOpt($Opt)
    {
        $this->Opt = $Opt;
    }

    /**
    * Data Validation
    *
    * @return boolean
    */
    public function validData()
    {
        $msg = "";
        if ($this->TxnType != "Purchase") {
            if ($this->TxnType != "Auth") {
                $msg = "Invalid TxnType[$this->TxnType]<br>";
            }
        }
        if (strlen($this->MerchantReference) > 64) {
            $msg = "Invalid MerchantReference [$this->MerchantReference]<br>";
        }
        if (strlen($this->TxnId) > 16) {
            $msg = "Invalid TxnId [$this->TxnId]<br>";
        }
        if (strlen($this->TxnData1) > 255) {
            $msg = "Invalid TxnData1 [$this->TxnData1]<br>";
        }
        if (strlen($this->TxnData2) > 255) {
            $msg = "Invalid TxnData2 [$this->TxnData2]<br>";
        }
        if (strlen($this->TxnData3) > 255) {
            $msg = "Invalid TxnData3 [$this->TxnData3]<br>";
        }
        if (strlen($this->EmailAddress) > 255) {
            $msg = "Invalid EmailAddress [$this->EmailAddress]<br>";
        }
        if (strlen($this->UrlFail) > 255) {
            $msg = "Invalid UrlFail [$this->UrlFail]<br>";
        }
        if (strlen($this->UrlSuccess) > 255) {
            $msg = "Invalid UrlSuccess [$this->UrlSuccess]<br>";
        }
        if (strlen($this->BillingId) > 32) {
            $msg = "Invalid BillingId [$this->BillingId]<br>";
        }
        if ($msg != "") {
            trigger_error($msg, E_USER_ERROR);
            return false;
        }
        return true;
    }
}