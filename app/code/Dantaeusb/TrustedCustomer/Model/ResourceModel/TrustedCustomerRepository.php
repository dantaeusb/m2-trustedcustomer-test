<?php


namespace Dantaeusb\TrustedCustomer\Model\ResourceModel;

use Dantaeusb\TrustedCustomer\Setup\InstallData;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Dantaeusb\TrustedCustomer\Api\TrustedCustomerRepositoryInterface;
use Magento\Framework\Webapi\Exception;

class TrustedCustomerRepository implements TrustedCustomerRepositoryInterface
{
    private $customerFactory;

    private $searchResultsFactory;

    /**
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        CustomerSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @todo Maybe pass handling to native CustomerRepository
     * @see \Magento\Customer\Model\ResourceModel\CustomerRepository::getList()
     *
     * @param int $page
     * @param int $pageSize
     *
     * @return CustomerSearchResultsInterface|void
     * @throws Exception
     */
    public function listTrusted($page = 0, $pageSize = 10)
    {
        $searchResults = $this->searchResultsFactory->create();

        /**
         * Or we can throw exception cause it's
         */
        if (!is_numeric($page) || !is_numeric($pageSize)) {
            throw new Exception ( __('Invalid pagination parameters'), Exception::HTTP_BAD_REQUEST);
        }

        if ($pageSize > 250) {
            throw new Exception ( __('Too many items requested'), Exception::HTTP_BAD_REQUEST);
        }

        $from = new \DateTime();
        $from->modify("-1 day");
        $from = $from->format("Y-m-d H:i:s");

        $collection = $this->customerFactory->create()->getCollection();
        $collection
            ->addAttributeToFilter(InstallData::TRUSTED_ATTRIBUTE_CODE, true)
            ->addAttributeToFilter('created_at', ['from' => $from])
            ->setPageSize($pageSize)
            ->setCurPage($page);

        $customers = [];

        /** @var Customer $trustedCustomer */
        foreach ($collection as $trustedCustomer) {
            $customers[] = $trustedCustomer->getDataModel();
        }

        $searchResults->setItems($customers);
        return $searchResults;
    }
}