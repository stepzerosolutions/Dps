<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Dps\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
	protected $logger;
	
	
    public function __construct(EavSetupFactory $eavSetupFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->eavSetupFactory = $eavSetupFactory;
		$this->logger = $logger;
    }
	
	
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
					['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true, 'auto_increment' => true],
					'Variation id'
				)->addColumn(
					'debug_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['default' => 'CURRENT_TIMESTAMP', 'nullable' => false, 'on update' => 'CURRENT_TIMESTAMP'],
					'Debug time'
				)->addColumn(
					'request_body',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					null,
					['nullable' => true],
					'Units booking'
				)->addColumn(
					'response_body',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					null,
					['nullable' => true],
					'Units booking'
				)->setComment(
					'DPS debug'
				);
				$setup->getConnection()->createTable($table);
			}
			
			if (version_compare($context->getVersion(), '0.0.7') < 0) {
				$data = [];
				$statuses = [
					'pending_dps' => __('Pending Payment (DPS)'),
					'processing_dps_auth' => __('Processing (DPS - Amount authorised)'),
					'processing_dps_paid' => __('Processing (DPS - Amount paid)'),
				];
				foreach ($statuses as $code => $info) {
					$data[] = ['status' => $code, 'label' => $info];
				}
				$setup->getConnection()->insertArray($setup->getTable('sales_order_status'), ['status', 'label'], $data);
			}
			
			$setup->endSetup();
    }
	
}