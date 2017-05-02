<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

/**
 * DPS module observer
 */
class CheckoutSubmitBeforeObserver implements ObserverInterface
{
	protected $_logger;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
		\Psr\Log\LoggerInterface $logger //log injection
    ) {
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
		$this->_logger->debug('redirect url observer');
		return $this;
    }
}
