<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Dps\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SalesOrderSaveAfterObserver implements ObserverInterface
{
	protected $_coreRegistry;
	protected $_logger;

	
    public function __construct(
		\Magento\Framework\Registry $coreRegistry,
		\Psr\Log\LoggerInterface $logger //log injection
    ) {
		$this->_coreRegistry = $coreRegistry;
		$this->_logger = $logger;
    }


    /**
     * Set Booking items to active
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {		
//		$observer->getEvent()->getOrder()->setCanSendNewEmailFlag(false)->save();
		return $this;
    }


}
