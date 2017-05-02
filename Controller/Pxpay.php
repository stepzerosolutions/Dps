<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Controller;


/**
 * Class Pxpay
 */
abstract class Pxpay extends \Magento\Framework\App\Action\Action
{
	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $resultPageFactory;
	
	protected $logger;
    /**
     * @var \Stepzerosolutions\Dps\Model\Redirect
     */
    protected $_pxpayredirect;
	protected $_test;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
		\Stepzerosolutions\Dps\Model\Redirect $pxpayredirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
//		\Stepzerosolutions\Dps\Model\Test $test,
		\Psr\Log\LoggerInterface $logger //log injection
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
		$this->logger = $logger;
		$this->_pxpayredirect = $pxpayredirect;
//		$this->_test = $test;
    }

}
