<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Upgrade class
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

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Upgrade data Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
    * Init
    */
    protected $logger;

    /**
    * Constructor
    *
    * @param EavSetupFactory $eavSetupFactory EAV
    * @param LoggerInterface $logger          Logger
    *
    * @return void
    */
    public function __construct(
        EavSetupFactory $eavSetupFactory, 
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->logger = $logger;
    }
    
    /**
    * Upgrade
    *
    * @param ModuleDataSetupInterface $setup   Setup
    * @param ModuleContextInterface   $context Contect
    *
    * @return void
    */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.4') < 0) {
            $tableName = $setup->getTable('dps_debug');
            $table = $setup->getConnection()->newTable(
                $setup->getTable($tableName)
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 
                 'unsigned' => true, 
                 'nullable' => false, 
                 'primary' => true, 
                 'auto_increment' => true
                ],
                'id'
            )->addColumn(
                'debug_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['default' => 'CURRENT_TIMESTAMP', 
                 'nullable' => false, 
                 'on update' => 'CURRENT_TIMESTAMP'
                ],
                'Debug time'
            )->addColumn(
                'request_body',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Request body'
            )->addColumn(
                'response_body',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => true],
                'Response'
            )->setComment(
                'DPS debug'
            );
            $setup->getConnection()->createTable($table);
        }
        $setup->endSetup();
    }
}
