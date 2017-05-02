<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

/**
 * PayPal module observer
 */
class SetResponseAfterSaveOrderObserver implements ObserverInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
	protected $_logger;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
		\Psr\Log\LoggerInterface $logger //log injection
    ) {
        $this->_coreRegistry = $coreRegistry;
		$this->_logger = $logger;
    }

    /**
     * Save order into registry to use it in the overloaded controller.
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        /* @var $order \Magento\Sales\Model\Order */
        $order = $this->_coreRegistry->registry('dps_order');

        if ($order && $order->getId()) {
            $payment = $order->getPayment();
            if ($payment && in_array($payment->getMethod(), \Stepzerosolutions\Dps\Model\Common::METHOD_CODE)) {
                $result = $observer->getData('result')->getData();
                if (empty($result['error'])) {
                    $result['redirect'] = false;
                    $observer->getData('result')->setData($result);
                }
            }
        }
    }
}
