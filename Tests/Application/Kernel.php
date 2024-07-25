<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Application;

use Sulu\Bundle\TestBundle\Kernel\SuluTestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends SuluTestKernel
{
    public function registerBundles(): iterable
    {
        $bundles = [
            new \Sulu\Bundle\SyliusConsumerBundle\SuluSyliusConsumerBundle(),
        ];

        if (self::CONTEXT_WEBSITE === $this->getContext()) {
            $bundles[] = new \Symfony\Bundle\SecurityBundle\SecurityBundle();
        }

        return \array_merge($bundles, parent::registerBundles());
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        parent::registerContainerConfiguration($loader);

        $loader->load(__DIR__ . '/config/config_' . $this->getContext() . '.yml');
    }

    protected function getKernelParameters(): array
    {
        $parameters = parent::getKernelParameters();
        $parameters['kernel.root_dir'] = __DIR__; // TODO remove when lowest version increased

        return $parameters;
    }
}
