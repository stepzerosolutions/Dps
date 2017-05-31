<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Model class
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
namespace Stepzerosolutions\Dps\Model;

use Stepzerosolutions\Dps\Model\Common as Commons;
use \Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface;
/**
 * PxPay Connection Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Pxpay extends \Magento\Payment\Model\Method\AbstractMethod
{
    public $_code;
    
    protected $logger;
    
    /**
    * @var Repository
    */
    protected $assetRepo;
    
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_isGateway = true;
    
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canAuthorize = true;
    
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canCapture = true;
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canRefund = true;
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canRefundInvoicePartial = false;
    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canVoid = true;

    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_canFetchTransactionInfo = true;

    /**
    * Payment Method feature
    *
    * @var bool
    */
    public $_isInitializeNeeded = true;

    /**
    * @var \Magento\Store\Model\StoreManagerInterface
    */
    protected $storeManager;

    /**
    * @var \Magento\Quote\Api\CartRepositoryInterface
    */
    protected $quoteRepository;

    /**
    * @var \Magento\Authorizenet\Model\Directpost\Response
    */
    protected $response;

    /**
    * @var OrderSender
    */
    protected $orderSender;

    /**
    * Order factory
    *
    * @var \Magento\Sales\Model\OrderFactory
    */
    protected $orderFactory;

    /**
    * @var \Magento\Sales\Api\TransactionRepositoryInterface
    */
    protected $transactionRepository;
    
    public $_supportedCurrencyCodes = array('NZD');
    
    /**
    * Construct
    *
    * @param Context                        $context          Context
    * @param Registry                       $registry         Registry
    * @param ExtensionAttributesFactory     $extensionFactory Factory
    * @param AttributeValueFactory          $attributeFactory Custom
    * @param Data                           $paymentData      Payment
    * @param ScopeConfigInterface           $scopeConfig      Config
    * @param Logger                         $logger           Logger
    * @param StoreManagerInterface          $storeManager     Store
    * @param UrlInterface                   $urlBuilder       Url
    * @param Session                        $checkoutSession  Session
    * @param LocalizedExceptionFactory      $exception        Exception
    * @param TransactionRepositoryInterface $transaction      Transaction
    * @param BuilderInterface               $transBuilder     Builder
    * @param AbstractResource               $resource         Resource
    * @param AbstractDb                     $collection       Collection
    * @param array                          $data             Data
    *
    * @SuppressWarnings(PHPMD.ExcessiveParameterList)
    */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $attributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Exception\LocalizedExceptionFactory $exception,
        \Magento\Sales\Api\TransactionRepositoryInterface $transaction,
        BuilderInterface $transBuilder,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $collection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $attributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $collection,
            $data
        );
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
        $this->_checkoutSession = $checkoutSession;
        $this->_exception = $exception;
        $this->transactionRepository = $transaction;
        $this->transactionBuilder = $transBuilder;
        $this->logger = $logger;
    }

    /**
     * Method that will be executed instead of authorize or capture
     * if flag isInitializeNeeded set to true
     *
     * @param string $paymentAction Payment action
     * @param object $stateObject   state
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @api
     */
    public function initialize($paymentAction, $stateObject)
    {
        return $this;
    }
    /**
     * Get Code
     *
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @api
     */
    public function getCode()
    {
        return Commons::METHOD_CODE;
    }
    
    /**
    * Is active
    *
    * @param int|null $storeId Store Id
    *
    * @return bool
    */
    public function isActive($storeId = null)
    {
        return (bool)(int)$this->getConfigData('active', $storeId);
    }
    
    /**
    * Retrieve information from payment configuration
    *
    * @param string           $field   Field
    * @param int|string|null| $storeId Store Id
    *
    * @return mixed
    */
    public function getConfigData($field, $storeId = null)
    {
        if ('order_place_redirect_url' === $field) {
            return true;
        }
        if (null === $storeId) {
            $storeId = $this->getStore();
        }
        $path = 'payment/' . $this->getCode() . '/' . $field;
        return $this->_scopeConfig->getValue(
            $path, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, 
            $storeId
        );
    }
    
    /**
    * Get instructions text from config
    *
    * @return string
    */
    public function getInstructions()
    {
        return trim("Px Pay");
    }
    
    /**
    * Order payment
    *
    * @param InfoInterface $payment Payment
    * @param float         $amount  Amount
    *
    * @return $this
    * @throws \Magento\Framework\Exception\LocalizedException
    */
    public function order(
        \Magento\Payment\Model\InfoInterface $payment, 
        $amount
    ) {
        $order = $payment->getOrder();
        $orderTransactionId = $payment->getTransactionId();

        $state = Common::ORDER_STATUS_PENDING_DPS;
        $status = true;
        
        $formattedPrice = $order->getBaseCurrency()->formatTxt($amount);
        if ($payment->getIsTransactionPending()) {
            $message = __(
                'The ordering amount of %1 is pending approval
            on the payment gateway.', 
                $formattedPrice
            );
            $state = \Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW;
        } else {
            $message = __('Ordered amount of %1', $formattedPrice);
        }
        
        $transaction = $this->transactionBuilder->setPayment($payment)
            ->setOrder($order)
            ->setTransactionId($payment->getTransactionId())
            ->build(Transaction::TYPE_ORDER);
        $payment->addTransactionCommentsToOrder($transaction, $message);
        
        if ($payment->getIsTransactionPending()) {
            $message = __(
                'We\'ll authorize the amount of %1 as soon as the 
                payment gateway approves it.',
                $formattedPrice
            );
            $state = \Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW;
            if ($payment->getIsFraudDetected()) {
                $status = \Magento\Sales\Model\Order::STATUS_FRAUD;
            }
        } else {
            $message = __('The authorized amount is %1.', $formattedPrice);
        }
        
        $transaction = $this->transactionBuilder->setPayment($payment)
            ->setOrder($order)
            ->setTransactionId($payment->getTransactionId())
            ->build(Transaction::TYPE_AUTH);
        $payment->addTransactionCommentsToOrder($transaction, $message);
        $order->setStatus(Common::ORDER_STATUS_PENDING_DPS);
        return $this;
    }
    
    /**
    * Capture payment
    *
    * @param InfoInterface $payment payment
    * @param float         $amount  Amount
    *
    * @return $this
    *
    * @SuppressWarnings(PHPMD.CyclomaticComplexity)
    * @SuppressWarnings(PHPMD.NPathComplexity)
    */
    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $order = $payment->getOrder();
        $payment->setTransactionId($payment->getTransactionId());
        $payment->setIsTransactionClosed(false);
        return $this;
    }
}
