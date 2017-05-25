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

use Stepzerosolutions\Dps\Model\Common as Common;
use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\Order\Payment\Transaction;
use Magento\Sales\Api\Data\OrderPaymentInterface;
use Magento\Store\Model\StoreManagerInterface;
/**
 * PxPay Redirect Class
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Redirect
{
    /**
    * @var \Psr\Log\LoggerInterface
    */
    protected $logger;
    
    /**
    * @var \Magento\Sales\Model\OrderFactory
    */
    private $_order;
    
    /**
    * @var \Magento\Sales\Model\OrderFactory
    */
    private $_orderFactory;
    
    /**
    * @var \Magento\Sales\Api\TransactionRepositoryInterface
    */
    protected $transactionRepository;
    
    /**
    * @var \Stepzerosolutions\Dps\Model\Includes\PxPayRequest
    */
    private $_pxpayrequest;
    
    /**
    * @var \Stepzerosolutions\Dps\Model\Includes\PxPayCurl
    */
    private $_pxpaycurl;
    
    /**
    * @var \Magento\Framework\UrlInterface
    */
    private $_urlBuilder;
    
    /**
    * @var \Stepzerosolutions\Dps\Model\Includes\MifMessage
    */
    private $_mifmessage;
    
    /**
    * @var  \Magento\Framework\App\Config\ScopeConfigInterface
    */
    private $_scopeConfig;
    
    /**
    * @var StoreManagerInterface $storeManager
    */
    private $_storeManager;
    
    
    private $_captureData;
    
    /**
    * @var OrderSender
    */
    protected $orderSender;
    
    /**
    * @var Repository
    */
    protected $assetRepo;
    
    /**
    * @var InvoiceSender
    */
    protected $invoiceSender;
    
    /**
    * @var \Magento\Sales\Model\Service\InvoiceService
    */
    protected $invoiceServices;
    
    protected $customerNotified = false;
    
    /**
    * Construct
    *
    * @param OrderFactory                   $orderFactory          Order
    * @param TransactionRepositoryInterface $transactionRepository Transaction
    * @param PxPayRequest                   $pxpayrequest          PxPayRequest
    * @param PxPayCurl                      $pxpaycurl             PxPayCurl
    * @param MifMessage                     $mifmessage            Mif
    * @param UrlInterface                   $urlBuilder            Url
    * @param StoreManagerInterface          $storeManager          Store
    * @param ScopeConfigInterface           $scopeConfig           Config
    * @param OrderSender                    $orderSender           Order Send
    * @param InvoiceSender                  $invoiceSender         Invoice sender
    * @param InvoiceService                 $invoiceServices       Invoice
    * @param LoggerInterface                $logger                Logger
    *
    * @SuppressWarnings(PHPMD.ExcessiveParameterList)
    */
    public function __construct(
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository,
        \Stepzerosolutions\Dps\Model\Includes\PxPayRequest $pxpayrequest,
        \Stepzerosolutions\Dps\Model\Includes\PxPayCurl $pxpaycurl,
        \Stepzerosolutions\Dps\Model\Includes\MifMessage $mifmessage,
        \Magento\Framework\UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender,
        \Magento\Sales\Model\Service\InvoiceService $invoiceServices,
        \Psr\Log\LoggerInterface $logger //log injection
    ) {
        $this->logger = $logger;
        $this->_pxpayrequest = $pxpayrequest;
        $this->_pxpaycurl = $pxpaycurl;
        $this->_mifmessage = $mifmessage;
        $this->_orderFactory = $orderFactory;
        $this->transactionRepository = $transactionRepository;
        $this->_urlBuilder = $urlBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->loadConfiguration();
        $this->orderSender = $orderSender;
        $this->invoiceSender = $invoiceSender;
        $this->invoiceServices = $invoiceServices;
    }

    /**
     * Load Configuration
     *
     * @return $this
     */
    protected function loadConfiguration()
    {
        $key = $this->getConfigData("pxpaykey");
        $pxuserid =  $this->getConfigData("pxpayuserid");
        $pxpayUrl = $this->getConfigData("pxpayurl");
        $this->_pxpaycurl->setPxpayData($key, $pxpayUrl, $pxuserid);
    }
    
    /**
     * Get order
     *
     * @return object
     */
    protected function getOrder()
    {
        return $this->_order;
    }
    
    /**
     * Set order
     *
     * @param int $orderid Orderid
     *
     * @return void
     */
    public function setOrder($orderid)
    {
        $this->_order = $this->_orderFactory->create()->load((int)$orderid);
    }
    
    /**
     * Set DPS Process
     *
     * @return void
     */
    public function setDPSProcess()
    {
        if ($this->_order) {
            $payment = $this->_order->getPayment();
            if ($payment->getMethod()==Common::METHOD_CODE) {
                $this->generateReqest();
                $request_string = $this->_pxpaycurl->makeRequest(
                    $this->_pxpayrequest
                );
                $response = $this->_mifmessage->loadMifMessage($request_string);
                $url = $this->_mifmessage->getElementText("URI");
                $valid = $this->_mifmessage->getAttribute("valid");
                header("Location: ".$url);
                exit();
            }
        }
        $this->logger->critical("Set order ID to process the payment");
    }

    /**
     * Generate Request
     *
     * @return void
     */
    protected function generateReqest()
    {
        $TxnId = uniqid("ID");
        $this->_pxpayrequest->setMerchantReference($this->_order->getId());
        $this->_pxpayrequest->setAmountInput(
            $this->_order->getPayment()->getAmountOrdered()
        );
        $this->_pxpayrequest->setTxnData1(
            implode(" ", $this->_order->getBillingAddress()->getStreet())
        );
        $this->_pxpayrequest->setTxnData2(
            $this->_order->getBillingAddress()->getCity()
        );
        $this->_pxpayrequest->setTxnData3(
            $this->_order->getBillingAddress()->getPostcode()
        );
        $this->_pxpayrequest->setTxnType("Purchase");
        $this->_pxpayrequest->setCurrencyInput($this->_order->getBaseCurrencyCode());
        $this->_pxpayrequest->setEmailAddress(
            $this->_order->getBillingAddress()->getEmail()
        );
        $this->_pxpayrequest->setUrlFail(
            htmlentities($this->_urlBuilder->getUrl(Common::PXPAY_URL_FAIL))
        );
        $this->_pxpayrequest->setUrlSuccess(
            htmlentities($this->_urlBuilder->getUrl(Common::PXPAY_URL_SUCCESS))
        );
        $this->_pxpayrequest->setTxnId($TxnId);
    }
    
    /**
     * Process Faliure transaction
     *
     * @param array $result Result
     *
     * @return void
     */
    public function processFaliure($result)
    {
        $resultFeed = $this->_pxpaycurl->getResponse($result);
        if (!$resultFeed->getSuccess()) {
            $this->setOrder((int)$resultFeed->getMerchantReference());
            $this->_captureData = $resultFeed;
            $this->_registerFaliureCaption();
        }
    }
    
    /**
     * Process Success transaction
     *
     * @param array $result Result
     *
     * @return void
     */
    public function processSuccess($result)
    {
        $successFeed = $this->_pxpaycurl->getResponse($result);
        if ($successFeed->getSuccess()) {
            $this->setOrder((int)$successFeed->getMerchantReference());
            $this->_captureData = $successFeed;
            $this->_registerCaption();
        }
    }
    
    /**
     * Faliure caption
     *
     * @return void
     */
    private function _registerFaliureCaption()
    {
        $this->_order->setStatus(Common::ORDER_STATUS_PENDING_DPS);
        if (!$this->_order->getEmailSent()) {
            $this->_order->addStatusHistoryComment(
                __(
                    'Order is not processed due to invalid payment #%1.',
                    $this->_order->getIncrementId()
                )
            )->setIsCustomerNotified(
                false
            )->setSendEmail(
                true
            );
            $this->_order->save();
        }
    }
    
    /**
     * Register Caption
     *
     * @return void
     */
    private function _registerCaption()
    {
        $payment = $this->_order->getPayment();
        $payment->setTransactionId(
            $this->_captureData->getDpsTxnRef() 
        );
        $payment->setCurrencyCode(
            $this->_captureData->getCurrencyInput()
        );
        $payment->registerCaptureNotification(
            (string)$this->_captureData->getAmountSettlement()
        )
            ->setAmountPaid($this->_captureData->getAmountSettlement())
            ->setCcExpMonth(substr($this->_captureData->getDateExpiry(), 0, 2))
            ->setCcType($this->_captureData->getCardName())
            ->setCcExpYear(substr($this->_captureData->getDateExpiry(), 2, 2))
            ->setCcOwner($this->_captureData->getCardHolderName());
        
        $this->_order->setStatus(Common::ORDER_STATUS_PROCESSING_DPS_PAID);
        if (!$this->_order->getEmailSent()) {
            $this->_order->setEmailSent(
                true
            )->addStatusHistoryComment(
                __(
                    'Order confirmation sent #%1.',
                    $this->_order->getIncrementId()
                )
            )->setIsCustomerNotified(
                true
            )->setSendEmail(
                false
            );
            $this->_order->prepareInvoice();
            $this->_order->save();
            $this->sendEmails($this->_order, 'order');
            
            if ($this->_order->hasInvoices()) {
                foreach ($this->_order->getInvoiceCollection() as $invoice) {
                    if ($invoice && !$invoice->getEmailSent()) {
                        if (!empty($invoice->getIncrementId())) {
                            $this->sendEmails($invoice, 'invoice');
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Send Email
     *
     * @param object $data   Data
     * @param string $entity Order
     *
     * @return void
     */
    protected function sendEmails(
        $data,
        $entity="order"
    ) {
        $emailtosend = $this->getConfigData('emailstosend');
        switch ($emailtosend) {
        case Common::EMAIL_SEND_INVOICE: // send invoice email only
            if ($entity=='invoice') {
                $this->invoiceSender->send($data, true);
            }
            break;
        case Common::EMAIL_SEND_BOTH: // send both
            if ($entity=='invoice') {
                $ivs = $this->invoiceSender->send($data, true);
            }
            if ($entity=='order') {
                $this->orderSender->send($data);
            }
            break;
        case Common::EMAIL_SEND_ORDER: // default - send order email only
            break;
        default:
            if ($entity=='order') {
                $this->orderSender->send($data);
            }
            break;
        }
    }
    
    /**
     * Retrieve information from payment configuration
     *
     * @param string $field   Field Data
     * @param mixed  $storeId Store
     *
     * @return mixed
     */
    public function getConfigData($field, $storeId = null)
    {
        if (null === $storeId) {
            $storeId = $this->_storeManager->getStore();
        }
        $path = 'payment/' . Common::METHOD_CODE . '/' . $field;
        return $this->_scopeConfig->getValue(
            $path, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, 
            $storeId
        );
    }
    
    /**
     * Create new invoice with maximum qty for invoice for each item
     * register this invoice and capture
     *
     * @return Invoice
     */
    private function _invoice()
    {
        $invoice = $this->_order->prepareInvoice();
        $invoice->register();
        $this->_order->addRelatedObject($invoice);
        return $invoice;
    }
}
