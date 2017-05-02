<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Controller\Pxpay;
use Magento\Framework\Exception\RemoteServiceUnavailableException;

class Failure extends \Stepzerosolutions\Dps\Controller\Pxpay
{
	
	
    public function execute()
    {
		$result = $this->getRequest()->getParam('result');
		if ( !$result ) {
			$this->_redirect('/');
		}
		// If no user id return 
		if ( !$result ) {
			$this->_redirect('/');
		}
		
        try {
            $this->_pxpayredirect->processFaliure($result);
			$this->_redirect('checkout/onepage/faliure/');
        } catch (RemoteServiceUnavailableException $e) {
            $this->logger->critical($e);
            $this->getResponse()->setStatusHeader(503, '1.1', 'Service Unavailable')->sendResponse();
            /** @todo eliminate usage of exit statement */
            exit;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->getResponse()->setHttpResponseCode(500);
        }
    }

}
