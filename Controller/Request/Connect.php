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
namespace Stepzerosolutions\Dps\Controller\Request;
use Magento\Framework\Exception\RemoteServiceUnavailableException;
/**
 * PxPay Connection Class.
 *
 * @category Controller
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Connect extends \Stepzerosolutions\Dps\Controller\Request
{
    /**
    * Execute
    *
    * @return void
    */
    public function execute()
    {
        try {
            if ($orderid = $this->checkoutSession->getLastOrderId()) {
                $this->pxpayredirect->setOrder($orderid);
                $this->pxpayredirect->setDPSProcess();
            }
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
        die();
    }
}
