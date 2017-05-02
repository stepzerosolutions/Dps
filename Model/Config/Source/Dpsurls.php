<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Config\Source;
/**
 * Payment urls source
 *
 */
  
class Dpsurls extends \Stepzerosolutions\Dps\Model\Common
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return $this->getPxpayUrls();
    }
}
