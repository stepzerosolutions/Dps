<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Controller class
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
namespace Stepzerosolutions\Dps\Controller\Pxpay;
use Magento\Framework\Exception\RemoteServiceUnavailableException;

/**
 * PxPay Failure Class.
 *
 * @category Controller
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Failure extends \Stepzerosolutions\Dps\Controller\Pxpay
{
    /**
    * Execute
    *
    * @return void
    */
    public function execute()
    {
        $result = $this->getRequest()->getParam('result');
        if ( !$result ) {
            $this->_redirect('/');
        }
        if ( !$result ) {
            $this->_redirect('/');
        }
        
        try {
            $this->pxpayredirect->processFaliure($result);
            $this->_redirect('checkout/onepage/faliure/');
        } catch (RemoteServiceUnavailableException $e) {
            $this->logger->critical($e);
            $this->getResponse()->setStatusHeader(
                503, 
                '1.1', 
                'Service Unavailable'
            )->sendResponse();
            /** @todo eliminate usage of exit statement */
            exit;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->getResponse()->setHttpResponseCode(500);
        }
    }

}
