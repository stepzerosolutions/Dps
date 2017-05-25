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

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Escaper;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;

/**
 * PxPay InstructionsConfigProvider
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class InstructionsConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Repository
     */
    protected $assetRepo;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    
    /**
     * @var string[]
     */
    protected $methodCodes = [
        Common::METHOD_CODE
    ];
    
    /**
     * @var \Magento\Payment\Model\Method\AbstractMethod[]
     */
    protected $methods = [];

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
    * Construct
    *
    * @param Repository       $assetRepo     Repository
    * @param RequestInterface $request       Request
    * @param UrlInterface     $urlBuilder    Url
    * @param PaymentHelper    $paymentHelper Payment
    * @param Escaper          $escaper       Escaper
    *
    * @SuppressWarnings(PHPMD.ExcessiveParameterList)
    */
    public function __construct(
        Repository $assetRepo,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        PaymentHelper $paymentHelper,
        Escaper $escaper
    ) {
        $this->assetRepo = $assetRepo;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->escaper = $escaper;
        foreach ($this->methodCodes as $code) {
            $this->methods[$code] = $paymentHelper->getMethodInstance($code);
        }
    }

    /**
     * Load Configuration
     *
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->methodCodes as $code) {
            if ($this->methods[$code]->isAvailable()) {
                $config['payment']['instructions'][$code] 
                    = $this->getInstructions($code);
            }
        }
        return $config;
    }

    /**
     * Get instructions text from config
     *
     * @param string $code Code
     *
     * @return string
     */
    protected function getInstructions($code)
    {
        return $this->generateInstructions($code);
    }
    
    /**
     * Generate instructions
     *
     * @param string $code Code
     *
     * @return string
     */
    public function generateInstructions($code)
    {
        $_logos = explode(
            ",", 
            $this->methods[$code]->getConfigData('pxpaydisplaylogos')
        );
        $output = __(
            'After clicking Place Order in the next step you will be 
            redirected to the DPS Payment Express website.'
        );
        $output .= '<div class="dps-logos">';
        $output .= '<img src="'.
            $this->getViewFileUrl(
                "Stepzerosolutions_Dps::images/dpspxlogo.png"
            ).'" alt="Dps Logo" />';
        foreach($_logos as $_logo):
            if ($_logo) :
                $output .= '<img src="'. $this->getViewFileUrl(
                    "Stepzerosolutions_Dps::images/".$_logo
                ) .'" alt="" />';
            endif;
        endforeach;
        $output .= '</div>';
        return $output;
    }
    
    /**
     * Retrieve url of a view file
     *
     * @param string $fileId FieldId
     * @param array  $params Params
     *
     * @return string[]
     */
    protected function getViewFileUrl($fileId, array $params = [])
    {
        try {
            $params = array_merge(
                ['_secure' => $this->request->isSecure()],
                $params
            );
            return $this->assetRepo->getUrlWithParams($fileId, $params);
        } catch (LocalizedException $e) {
            $this->logger->critical($e);
            return $this->urlBuilder->getUrl(
                '',
                ['_direct' => 'core/index/notFound']
            );
        }
    }
}
