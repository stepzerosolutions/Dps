<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Install class
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
namespace Stepzerosolutions\Dps\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
/**
 * Install data Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class InstallData implements InstallDataInterface
{
    /**
    * Sales setup factory
    *
    * @var SalesSetupFactory
    */
    protected $salesSetupFactory;

    /**
    * Constructor
    *
    * @param SalesSetupFactory $salesSetupFactory Setup
    *
    * @return void
    */
    public function __construct(
        SalesSetupFactory $salesSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
    }

    /**
    * Install
    *
    * @param ModuleDataSetupInterface $setup   Setup
    * @param ModuleContextInterface   $context Contect
    *
    * @return void
    */
    public function install(
        ModuleDataSetupInterface $setup, 
        ModuleContextInterface $context
    ) {
        /**
        * Prepare database for install
        */
        $setup->startSetup();

        $salesInstaller = $this->salesSetupFactory->create(
            ['resourceName' => 'sales_setup', 'setup' => $setup]
        );

        $data = [];
        $statuses = [
            'pending_dps' => __('Pending Payment (DPS)'),
            'processing_dps_auth' => __('Processing (DPS - Amount authorised)'),
            'processing_dps_paid' => __('Processing (DPS - Amount paid)'),
        ];
        foreach ($statuses as $code => $info) {
            $data[] = ['status' => $code, 'label' => $info];
        }
        $setup->getConnection()->insertArray(
            $setup->getTable('sales_order_status'), 
            ['status', 'label'], 
            $data
        );

        /**
         * Prepare database after install
         */
        $setup->endSetup();
    }
}