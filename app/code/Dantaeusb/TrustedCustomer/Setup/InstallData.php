<?php
/**
 *
 */

namespace Dantaeusb\TrustedCustomer\Setup;

use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    const TRUSTED_ATTRIBUTE_CODE = 'is_trusted_customer';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    private $eavConfig;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     */
    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            self::TRUSTED_ATTRIBUTE_CODE,
            [
                'type'         => 'boolean',
                'label'        => 'Is Trusted Customer',
                'input'        => 'select',
                'source'       => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'     => false,
                'visible'      => true,
                'user_defined' => true,
                'position'     => 20,
                'system'       => 0,
            ]
        );

        $this->addAttributeToAdminForm();
    }

    /**
     * @throws LocalizedException
     */
    private function addAttributeToAdminForm()
    {
        $trustedCustomerAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, self::TRUSTED_ATTRIBUTE_CODE);
        $trustedCustomerAttribute
            ->setData('used_inf_forms', ['adminhtml_customer'])
            ->save();

    }
}