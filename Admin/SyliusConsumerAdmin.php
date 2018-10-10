<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Routing\Route;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class SyliusConsumerAdmin extends Admin
{
    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    public function __construct(WebspaceManagerInterface $webspaceManager)
    {
        $this->webspaceManager = $webspaceManager;
    }

    public function getNavigation(): Navigation
    {
        $rootNavigationItem = $this->getNavigationItemRoot();

        $products = new NavigationItem('sulu_sylius_product.products');
        $products->setPosition(45);
        $products->setIcon('fa-cube');
        $products->setMainRoute('sulu_sylius_product.products_datagrid');

        $rootNavigationItem->addChild($products);

        return new Navigation($rootNavigationItem);
    }

    public function getRoutes(): array
    {
        $locales = array_values(
            array_map(
                function (Localization $localization) {
                    return $localization->getLocale();
                },
                $this->webspaceManager->getAllLocalizations()
            )
        );

        $formToolbarActions = [
            'sulu_admin.save',
            'sulu_admin.type',
        ];

        return [
            (new Route('sulu_sylius_product.products_datagrid', '/products/:locale', 'sulu_admin.datagrid'))
                ->addOption('title', 'sulu_sylius_product.products')
                ->addOption('adapters', ['table'])
                ->addOption('resourceKey', ProductInterface::RESOURCE_KEY)
                ->addOption('editRoute', 'sulu_sylius_product.product_edit_form.detail')
                ->addOption('locales', $locales)
                ->addAttributeDefault('locale', $locales[0]),
            (new Route('sulu_sylius_product.product_edit_form', '/products/:locale/:id', 'sulu_admin.resource_tabs'))
                ->addOption('resourceKey', ProductInterface::RESOURCE_KEY)
                ->addOption('toolbarActions', [])
                ->addOption('locales', $locales)
                ->addAttributeDefault('locale', $locales[0]),
            (new Route('sulu_sylius_product.product_edit_form.detail', '/details', 'sulu_admin.form'))
                ->addOption('tabTitle', 'sulu_sylius_product.details')
                ->addOption('backRoute', 'sulu_sylius_product.products_datagrid')
                ->addOption('toolbarActions', [])
                ->setParent('sulu_sylius_product.product_edit_form'),
            (new Route('sulu_sylius_product.product_edit_form.content', '/content', 'sulu_admin.form'))
                ->addOption('tabTitle', 'sulu_sylius_product.content')
                ->addOption('backRoute', 'sulu_sylius_product.products_datagrid')
                ->addOption('resourceKey', 'product_contents')
                ->addOption('toolbarActions', $formToolbarActions)
                ->setParent('sulu_sylius_product.product_edit_form'),
        ];
    }
}
