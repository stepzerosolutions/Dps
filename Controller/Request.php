<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Controller;


/**
 * Class Pxpay
 */
abstract class Request extends \Magento\Framework\App\Action\Action
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
	
	protected $checkoutSession;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Stepzerosolutions\Dps\Model\Redirect $pxpayredirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Psr\Log\LoggerInterface $logger //log injection
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
		$this->logger = $logger;
		$this->_pxpayredirect = $pxpayredirect;
		$this->checkoutSession = $checkoutSession;
    }

}
