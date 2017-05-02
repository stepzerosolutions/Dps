<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model;
/**
 * DPS PxPay Magento 2 Module
 *
 */

 
class Common
{
	const METHOD_CODE = 'dps_pxpay';
	
	
    const ACTION_AUTHORIZE = 'Auth';
    const ACTION_COMPLETE = 'Complete';
    const ACTION_PURCHASE = 'Purchase';
    const ACTION_REFUND = 'Refund';
    const ACTION_VALIDATE = 'Validate';

    /**
     * Credit Card Logos
     */
    const LOGOFILE_VISA = 'VisaLogo.png';
    const LOGOFILE_VISAVERIFIED = 'VisaVerifiedLogo.png';
    const LOGOFILE_MASTERCARD = 'MasterCardLogo.png';
    const LOGOFILE_MASTERCARDSECURE = 'MCSecureCodeLogo.png';
    const LOGOFILE_AMEX = 'AmexLogo.png';
    const LOGOFILE_JCB = 'JCBLogo.png';
    const LOGOFILE_DINERS = 'DinersLogo.png';
	

    const STATUS_ERROR = 0;
    const STATUS_OK_INVOICE = 2;
    const STATUS_OK_DONT_INVOICE = 3;
    const STATUS_OK_ALREADY_INVOICED = 4;

    const EMAIL_SEND_ORDER = 'send_order';
    const EMAIL_SEND_INVOICE = 'send_invoice';
    const EMAIL_SEND_BOTH = 'send_both';

    const PXPAY_URL = 'https://sec.paymentexpress.com/pxpay/pxaccess.aspx';
    const PXPAY20_URL = 'https://sec.paymentexpress.com/pxaccess/pxpay.aspx';
	const PXPAY20_TEST_URL = 'https://uat.paymentexpress.com/pxaccess/pxpay.aspx';

    const PXPAY_URL_SUCCESS = 'dps/pxpay/success';
    const PXPAY_URL_FAIL = 'dps/pxpay/failure';

    const DPS_LOG_FILENAME = 'dps_pxpay.log';
	
	
    /**
     * System Configurations
     */
    const XML_CONFIG_ISACTIVE = 'payment/dps_pxpay/active';

    const ORDER_STATUS_PENDING = 'pending';
    const ORDER_STATUS_PENDING_DPS = 'pending_dps';
    const ORDER_STATUS_PROCESSING_DPS_AUTH = 'processing_dps_auth';
    const ORDER_STATUS_PROCESSING_DPS_PAID = 'processing_dps_paid';
    /**
     * Error Codes
     * Code =>  Description
     */
    public $errorCodes
        = array(
            '51' => 'Card with Insufficient Funds',
            '54' => 'Expired Card',
            'IC' => 'Invalid Key or Username. Also check that if a TxnId is being supplied that it is unique.',
            'ID' => 'Invalid transaction type. Esure that the transaction type is either Auth or Purchase.',
            'IK' => 'Invalid UrlSuccess. Ensure that the URL being supplied does not contain a query string.',
            'IL' => 'Invalid UrlFail. Ensure that the URL being supplied does not contain a query string.',
            'IM' => 'Invalid PxPayUserId.',
            'IN' => 'Blank PxPayUserId.',
            'IP' => 'Invalid parameter. Ensure that only documented properties are being supplied.',
            'IQ' => 'Invalid TxnType. Ensure that the transaction type being submitted is either "Auth" or "Purchase".',
            'IT' => 'Invalid currency. Ensure that the CurrencyInput is correct and in the correct format e.g. "USD".',
            'IU' => 'Invalid AmountInput. Ensure that the amount is in the correct format e.g. "20.00".',
            'NF' => 'Invalid Username.',
            'NK' => 'Request not found. Check the key and the mcrypt library if in use.',
            'NL' => 'User not enabled. Contact DPS.',
            'NM' => 'User not enabled. Contact DPS.',
            'NN' => 'Invalid MAC.',
            'NO' => 'Request contains non ASCII characters.',
            'NP' => 'PXPay Closing Request tag not found.',
            'NQ' => 'User not enabled for PxPay. Contact DPS.',
            'NT' => 'Key is not 64 characters.',
            'U5' => 'Invalid User / Password',
            'U9' => 'Timeout for Transaction',
            'QD' => 'The transaction was Declined.', //Invalid TxnRef
            'Q4' => 'Invalid Amount Entered. Transaction has not been Approved',
            'Q8' => 'Invalid Currency',
            'QG' => 'Invalid TxnType',
            'QI' => 'Invalid Expiry Date (month not between 1-12)',
            'QJ' => 'Invalid Expiry Date (non numeric value submitted)',
            'QK' => 'Invalid Card Number Length',
            'QL' => 'Invalid Card Number',
            'JC' => 'Invalid BillingId',
            'JD' => 'Invalid DPSBillingId',
            'JE' => 'DPSBillingId not matched',
            'D2' => 'Invalid username',
            'D3' => 'Invalid / missing Password',
            'D4' => 'Maximum number of logon attempts exceeded'
        );

    protected $_supportedCurrencies
        = array(
            'AUD', //Australian Dollar
            'BRL', //Brazil Real
            'BND', //Brunei Dollar
            'CAD', //Canadian Dollar
            'CNY', //Chinese Yuan Renminbi
            'CZK', //Czech Korunaor
            'DKK', //Danish Kroner
            'EGP', //Egyptian Pound
            'EUR', //Euros
            'FJD', //Fiji Dollar
            'HKD', //Hong Kong Dollar
            'HUF', //Hungarian Forint
            'INR', //Indian Rupee
            'IDR', //Indonesia Rupiah
            'JPY', //Japanese Yen
            'KRW', //Korean Won
            'MOP', //Macau Pataca
            'MYR', //Malaysian Ringgit
            'MUR', //Mauritius Rupee
            'ANG', //Netherlands Guilder
            'TWD', //New Taiwan Dollar
            'NOK', //Norwegian Kronor
            'NZD', //New Zealand Dollar
            'PGK', //Papua New Guinea Kina
            'PHP', //Philippine Peso
            'PLN', //Polish Zloty
            'GBP', //Pound Sterling
            'PKR', //Pakistan Rupee
            'WST', //Samoan Tala
            'SAR', //Saudi Riyal
            'SBD', //Solomon Islands Dollar
            'LKR', //Sri Lankan Rupee
            'SGD', //Singapore Dollar
            'ZAR', //South African Rand
            'SEK', //Swedish Kronor
            'CHF', //Swiss Franc
            'TWD', //Taiwan Dollar
            'THB', //Thai Baht
            'TOP', //Tongan Pa'anga
            'AED', //UAE Dirham
            'USD', //United States Dollar
            'VUV' //Vanuatu Vatu
        );



    public function returnErrorExplanation($code)
    {
        $code = (string)$code;
        if (isset($this->errorCodes[$code])) {
            return $this->errorCodes[$code];
        } else {
            return "Failed with unknown error code " . $code;
        }
    }
	
	
	public function getPxpayUrls(){
		return [
			self::PXPAY_URL => 'PxPay',
			self::PXPAY20_URL => 'PxPay 2.0',
			self::PXPAY20_TEST_URL => 'PxPay 2.0 Test'
		];	
	}
}
