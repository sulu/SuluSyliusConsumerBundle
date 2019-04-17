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

namespace Sulu\Bundle\SyliusConsumerBundle\OAuth2;

use GuzzleHttp\ClientInterface;
use Sainsburys\Guzzle\Oauth2\AccessToken;
use Sainsburys\Guzzle\Oauth2\GrantType\GrantTypeInterface;
use Sainsburys\Guzzle\Oauth2\GrantType\RefreshTokenGrantTypeInterface;
use Sainsburys\Guzzle\Oauth2\Middleware\OAuthMiddleware;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * Inspired from https://github.com/gregurco/GuzzleBundleOAuth2Plugin/blob/master/src/Middleware/CachedOAuthMiddleware.php.
 */
class CachedOAuthMiddleware extends OAuthMiddleware
{
    const CLIENT_NAME = 'sylius';

    /**
     * @var AdapterInterface cacheClient
     */
    private $cacheClient;

    public function __construct(
        ClientInterface $client,
        GrantTypeInterface $grantType = null,
        RefreshTokenGrantTypeInterface $refreshTokenGrantType = null,
        AdapterInterface $cacheClient
    ) {
        parent::__construct($client, $grantType, $refreshTokenGrantType);

        $this->cacheClient = $cacheClient;
    }

    /**
     * Get a new access token and call the cacheToken method if available.
     */
    protected function acquireAccessToken(): ?AccessToken
    {
        $token = parent::acquireAccessToken();

        if ($token) {
            $this->cacheToken($token);
        }

        return $token;
    }

    /**
     * Sets the token in the cache adapter.
     */
    protected function cacheToken(AccessToken $token): void
    {
        /** @var CacheItem $item */
        $item = $this->cacheClient->getItem(sprintf('oauth.token.%s', self::CLIENT_NAME));

        $item->set(
            [
                'token' => $token->getToken(),
                'type' => $token->getType(),
                'data' => $token->getData(),
            ]
        );

        $expires = $token->getExpires();
        if ($expires) {
            $item->expiresAt($expires->sub(\DateInterval::createFromDateString('1 minute')));
        }

        $this->cacheClient->saveDeferred($item);
    }

    /**
     * Get the oauth token from the cache if available.
     */
    public function getAccessToken(): ?AccessToken
    {
        if (null === $this->accessToken) {
            $this->restoreTokenFromCache();
        }

        return parent::getAccessToken();
    }

    /**
     * Restore token from cache.
     */
    protected function restoreTokenFromCache(): void
    {
        $item = $this->cacheClient->getItem(sprintf('oauth.token.%s', self::CLIENT_NAME));

        if ($item->isHit()) {
            $tokenData = $item->get();

            $this->setAccessToken(
                new AccessToken(
                    $tokenData['token'],
                    $tokenData['type'],
                    $tokenData['data']
                )
            );
        }
    }
}
