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

use Stepzerosolutions\Dps\Model\Includes\PxPayResponse as PxPayResponse;
/**
 * PxPay PxPayCurl Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class PxPayCurl
{
    protected $PxPay_Key;
    protected $PxPay_Url;
    protected $PxPay_Userid;
    protected $pxresponse;
    
    /**
    * Construct
    *
    * @param PxPayResponse $response Response
    *
    * @SuppressWarnings(PHPMD.ExcessiveParameterList)
    */
    public function __construct(
        PxPayResponse $response
    ) {
        $this->pxresponse = $response;
    }
    
    /**
     * Set PXPay data
     *
     * @param string $pxpayKey    Key
     * @param string $pxpayUrl    Url
     * @param string $pxpayUserid Id
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @api
     */
    public function setPxpayData($pxpayKey, $pxpayUrl, $pxpayUserid)
    {
        $this->PxPay_Key = $pxpayKey;
        $this->PxPay_Url = $pxpayUrl;
        $this->PxPay_Userid = $pxpayUserid;
    }
    
    /**
     * Create a request for the PxPay interface
     *
     * @param object $request Request
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @api
     */
    public function makeRequest($request)
    {
        if ($request->validData() == false) {
            return false ;
        }
        $request->setUserId($this->PxPay_Userid);
        $request->setKey($this->PxPay_Key);
        $xml = $request->toXml();
        $result = $this->submitXml($xml);
        return $result;
    }
    
    /**
    * Return the transaction outcome details
    *
    * @param string $result Result
    *
    * @return $this
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    * @api
    */
    public function getResponse($result)
    {
        if ($this->PxPay_Userid) {
            $inputXml = "<ProcessResponse><PxPayUserId>"
                .$this->PxPay_Userid
                ."</PxPayUserId><PxPayKey>".$this->PxPay_Key
                ."</PxPayKey><Response>".$result."</Response></ProcessResponse>";
            $outputXml = $this->submitXml($inputXml);
            return $this->pxresponse->prcessResponse($outputXml);
        } else {
            return false;
        }
    }
    
    /**
    * Actual submission of XML using cURL. Returns output XML
    *
    * @param object $inputXml Result
    *
    * @return $this
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    * @api
    */
    public function submitXml($inputXml)
    {
        $outputXml='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->PxPay_Url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $inputXml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        //set up proxy, this may change depending on ISP, 
        //please contact your ISP to get the correct cURL settings
        //curl_setopt($ch,CURLOPT_PROXY , "proxy:8080");
        //curl_setopt($ch,CURLOPT_PROXYUSERPWD,"username:password");
        $outputXml = curl_exec($ch);
        curl_close($ch);
        return $outputXml;
    }
}
