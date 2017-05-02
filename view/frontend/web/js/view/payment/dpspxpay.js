/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'dps_pxpay',
                component: 'Stepzerosolutions_Dps/js/view/payment/method-renderer/dps-pxpay'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);