<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Observer class
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
namespace Stepzerosolutions\Dps\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
/**
 * SaveOrderAfterSubmitObserver Class.
 *
 * @category Observer
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class SaveOrderAfterSubmitObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $_coreRegistry;

    /**
    * @var \Psr\Log\LoggerInterface
    */
    private $_logger;
    
    /**
    * Constructor
    *
    * @param Registry        $coreRegistry Registry
    * @param LoggerInterface $logger       Logger
    *
    * @return void
    */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_logger = $logger;
    }
    
    /**
    * Execute
    *
    * @param EventObserver $observer Observer
    *
    * @return void
    */
    public function execute(EventObserver $observer)
    {
        $order = $this->_coreRegistry->registry('dps_order');

        if ($order && $order->getId()) {
            $payment = $order->getPayment();
            if ($payment
                && in_array(
                    $payment->getMethod(),
                    \Stepzerosolutions\Dps\Model\Common::METHOD_CODE
                )
            ) {
                $result = $observer->getData('result')->getData();
                if (empty($result['error'])) {
                    $result['redirect'] = false;
                    $observer->getData('result')->setData($result);
                }
            }
        }
    }
}
