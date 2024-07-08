<?php

namespace App\EventSubscriber;

use App\Service\RedisService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly RedisService $redisService)
    {
    }

    /**
     * Handles caching logic based on the presence of X-API-CACHE header.
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Check if X-API-CACHE header is present and equals 0
        $useCache = true;
        if ($request->headers->has('X-API-CACHE')) {
            $useCache = (bool) $request->headers->get('X-API-CACHE');
        }

        // If X-API-CACHE is 0, do not use cache
        if (!$useCache) {
            return;
        }

        // Generate a cache key based on the query string
        $queryString = $event->getRequest()->getQueryString();
        if (!empty($queryString)) {
            $cacheKey = md5($queryString);
            $cachedContent = $this->redisService->get($cacheKey);

            // If cached content exists, respond with cached data
            if (!empty($cachedContent)) {
                $responseData = json_decode($cachedContent, true);
                $response = new JsonResponse($responseData);
                $event->setResponse($response);
            }
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
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
