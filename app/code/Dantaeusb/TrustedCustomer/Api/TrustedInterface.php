<?php


namespace Dantaeusb\TrustedCustomer\Api;

use Magento\Customer\Api\Data\CustomerSearchResultsInterface;

interface TrustedCustomerRepositoryInterface
{
    /**
     * Get all trusted customers that were registered this day
     *
     * @param null|int $page
     * @param null|int $pageSize
     * @return CustomerSearchResultsInterface
     */
    public function listTrusted($page = 0, $pageSize = 10);
}