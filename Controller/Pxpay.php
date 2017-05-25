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
namespace Stepzerosolutions\Dps\Controller;

/**
 * PxPay Class.
 *
 * @category Controller
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
abstract class Pxpay extends \Magento\Framework\App\Action\Action
{
    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

    /**
    * @var \Psr\Log\LoggerInterface
    */
    protected $logger;
    
    /**
    * @var \Stepzerosolutions\Dps\Model\Redirect
    */
    protected $pxpayredirect;
    
    /**
    * Construct
    *
    * @param Context         $context           Context
    * @param Redirect        $pxpayredirect     Page Factory
    * @param PageFactory     $resultPageFactory Page Factory
    * @param LoggerInterface $logger            Page Factory
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Stepzerosolutions\Dps\Model\Redirect $pxpayredirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->logger = $logger;
        $this->pxpayredirect = $pxpayredirect;
    }
}
