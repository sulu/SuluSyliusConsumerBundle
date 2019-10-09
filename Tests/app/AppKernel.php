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

use Sulu\Bundle\TestBundle\Kernel\SuluTestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends SuluTestKernel
{
    public function registerBundles()
    {
        $bundles = [
            new \Sulu\Bundle\SyliusConsumerBundle\SuluSyliusConsumerBundle(),
        ];

        if (self::CONTEXT_WEBSITE === $this->getContext()) {
            $bundles[] = new \Symfony\Bundle\SecurityBundle\SecurityBundle();
        }

        return array_merge($bundles, parent::registerBundles());
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        parent::registerContainerConfiguration($loader);

        $loader->load(__DIR__ . '/config/config_' . $this->getContext() . '.yml');
    }
}
