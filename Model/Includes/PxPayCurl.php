<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Includes;

use Stepzerosolutions\Dps\Model\Includes\PxPayResponse as PxPayResponse;
/**
 * DPS PxPay Magento 2 Module
 * DPS MifMessage class for xml dom
 */
class PxPayCurl
{
	protected $PxPay_Key;
	protected $PxPay_Url;
	protected $PxPay_Userid;
	protected $_pxresponse;
	
	public function __construct(
		\Stepzerosolutions\Dps\Model\Includes\PxPayResponse $response
	){
		$this->_pxresponse = $response;
	}
	
	public function setPxpayData( $pxpayKey, $pxpayUrl, $pxpayUserid ){
		$this->PxPay_Key = $pxpayKey;
		$this->PxPay_Url = $pxpayUrl;
		$this->PxPay_Userid = $pxpayUserid;
	}
	
	
	#******************************************************************************
	# Create a request for the PxPay interface
	#******************************************************************************
	public function makeRequest($request)
	{
		#Validate the Request
		if($request->validData() == false) return false ;
		$request->setUserId($this->PxPay_Userid);
		$request->setKey($this->PxPay_Key);
		$xml = $request->toXml();
		$result = $this->submitXml($xml);
		return $result;
	}
			
	#******************************************************************************
	# Return the transaction outcome details
	#******************************************************************************
	public function getResponse($result){
		if( $this->PxPay_Userid ) {
			$inputXml = "<ProcessResponse><PxPayUserId>".$this->PxPay_Userid."</PxPayUserId><PxPayKey>".$this->PxPay_Key.
			"</PxPayKey><Response>".$result."</Response></ProcessResponse>";
			$outputXml = $this->submitXml($inputXml);
			return $this->_pxresponse->prcessResponse($outputXml);
		} else {
			return false;
		}
	}
	
	#******************************************************************************
	# Actual submission of XML using cURL. Returns output XML
	#******************************************************************************
	public function submitXml($inputXml){
		
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $this->PxPay_Url);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$inputXml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		#set up proxy, this may change depending on ISP, please contact your ISP to get the correct cURL settings
		#curl_setopt($ch,CURLOPT_PROXY , "proxy:8080");
		#curl_setopt($ch,CURLOPT_PROXYUSERPWD,"username:password");

		$outputXml = curl_exec ($ch); 		
			
		curl_close ($ch);
  
		return $outputXml;
	}
}