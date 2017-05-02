<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Config\Source;
/**
 * Payment actions source
 *
 */
  
class Emailstosend
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return [
			\Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_ORDER => __('Send Order Email Only'),
			\Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_INVOICE => __('Send Invoice Email Only'),
			\Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_BOTH => __('Send Both')
		];			
    }
}
