<?php

namespace App\EventSubscriber;

use App\Service\RedisService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly RedisService $redisService)
    {
    }

    /**
     * Handles caching of responses based on the X-API-CACHE header.
     *
     * @param ResponseEvent $event
     * @return void
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        // Check if X-API-CACHE header is present and equals 0
        $useCache = true;
        if ($request->headers->has('X-API-CACHE')) {
            $useCache = (bool) $request->headers->get('X-API-CACHE');
        }

        // If X-API-CACHE is 0, do not cache the response
        if (!$useCache) {
            return;
        }

        // Generate a cache key based on the query string
        $queryString = $event->getRequest()->getQueryString();
        if (!empty($queryString)) {
            $cacheKey = md5($queryString);
            $this->redisService->set($cacheKey, $event->getResponse()->getContent(), 3600);
        }
    }

    /**
     * Specifies the event to subscribe to.
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
