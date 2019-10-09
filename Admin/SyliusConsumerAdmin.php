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
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class SyliusConsumerAdmin extends Admin
{
    const PRODUCT_SECURITY_CONTEXT = 'sulu.global.products';

    const LIST_VIEW = 'sulu_sylius_consumer.products.list';

    const EDIT_FORM_VIEW = 'sulu_sylius_consumer.products.edit_form';

    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    public function __construct(
        WebspaceManagerInterface $webspaceManager,
        ViewBuilderFactoryInterface $viewBuilderFactory,
        SecurityCheckerInterface $securityChecker
    ) {
        $this->webspaceManager = $webspaceManager;
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->securityChecker = $securityChecker;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        if ($this->securityChecker->hasPermission(static::PRODUCT_SECURITY_CONTEXT, PermissionTypes::EDIT)) {
        $productItem = new NavigationItem('sulu_sylius_product.products');
        $productItem->setPosition(45);
        $productItem->setIcon('fa-cube');
        $productItem->setView(self::LIST_VIEW);
        $navigationItemCollection->add($productItem);
        }
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $locales = $this->webspaceManager->getAllLocales();

        $contentFormToolbarActions = [];
        $detailsFormToolbarActions = [];
        if ($this->securityChecker->hasPermission(static::PRODUCT_SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            $contentFormToolbarActions[] = new ToolbarAction('sulu_admin.save_with_publishing');
            $contentFormToolbarActions[] = new ToolbarAction('sulu_admin.type');
            $detailsFormToolbarActions[] = new ToolbarAction('sulu_admin.save');
        }

        $viewCollection->add(
            $this->viewBuilderFactory->createListViewBuilder(self::LIST_VIEW, '/products/:locale')
                ->setResourceKey(ProductInterface::RESOURCE_KEY)
                ->setListKey(ProductInterface::LIST_KEY)
                ->setTitle('sulu_sylius_product.products')
                ->addListAdapters(['table'])
                ->setEditView(self::EDIT_FORM_VIEW)
                ->addLocales($locales)
                ->setDefaultLocale($locales[0])
        );

        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(self::EDIT_FORM_VIEW, '/products/:locale/:id')
                ->setResourceKey(ProductInterface::RESOURCE_KEY)
                ->setBackView(self::LIST_VIEW)
                ->setTitleProperty('name')
                ->addLocales($locales)
        );

        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(self::EDIT_FORM_VIEW . '.details', '/details')
                ->setResourceKey(ProductInterface::RESOURCE_KEY)
                ->setFormKey(ProductInterface::FORM_KEY)
                ->setTabTitle('sulu_sylius_product.details')
                ->addToolbarActions($detailsFormToolbarActions)
                ->setParent(self::EDIT_FORM_VIEW)
        );

        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(self::EDIT_FORM_VIEW . '.content', '/content')
                ->setResourceKey(ProductInterface::CONTENT_RESOURCE_KEY)
                ->setFormKey(ProductInterface::CONTENT_FORM_KEY)
                ->setTabTitle('sulu_sylius_product.content')
                ->addToolbarActions($contentFormToolbarActions)
                ->setParent(self::EDIT_FORM_VIEW)
        );
    }

    public function getSecurityContexts()
    {
        return [
            'Sulu' => [
                'Global' => [
                    static::PRODUCT_SECURITY_CONTEXT => [
                        PermissionTypes::VIEW,
                        PermissionTypes::EDIT,
                    ],
                ],
            ],
        ];
    }
}
