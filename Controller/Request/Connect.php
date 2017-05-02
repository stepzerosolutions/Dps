<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Controller\Request;
use Magento\Framework\Exception\RemoteServiceUnavailableException;

class Connect extends \Stepzerosolutions\Dps\Controller\Request
{
	
    public function execute()
    {
        try {
			if( $orderid = $this->checkoutSession->getLastOrderId() ){
				// Make Curl Request
				$this->_pxpayredirect->setOrder($orderid );
				$this->_pxpayredirect->setDPSProcess();
			}
        } catch (RemoteServiceUnavailableException $e) {
            $this->logger->critical($e);
            $this->getResponse()->setStatusHeader(503, '1.1', 'Service Unavailable')->sendResponse();
            /** @todo eliminate usage of exit statement */
            exit;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->getResponse()->setHttpResponseCode(500);
        }
		die();
    }

}
