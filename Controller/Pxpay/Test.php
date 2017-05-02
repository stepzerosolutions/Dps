<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Controller\Pxpay;
use Magento\Framework\Exception\RemoteServiceUnavailableException;

class Test extends \Stepzerosolutions\Dps\Controller\Pxpay
{
	
	
    public function execute()
    {
        try {
			$this->_test->setOrder(34);
			$this->_test->setDPSProcess();
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
