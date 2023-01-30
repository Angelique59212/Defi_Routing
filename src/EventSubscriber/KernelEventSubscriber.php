<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
          KernelEvents::REQUEST => [
              ['displayKernelRequestTriggered', 255],
          ]  ,
            KernelEvents::EXCEPTION => [
                ['logKernelExceptionTriggered', 1]
            ],
        ];
    }

    public function displayKernelRequestTriggered(RequestEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getMethod() !== 'POST') {
            $response = new Response();
            $response->setContent('
                <h1>Type de requête non autorisée par le kernel</h1>
            ');
            $event->setResponse($response);
            $this->logger->info("Request finished", ['Error Message' => $request]);
        }
    }

    public function logKernelExceptionTriggered(ExceptionEvent $event)
    {
        $code = $event->getThrowable()->getCode();
        if ($code === 403) {
            $response = new Response();
            $response->setContent('
                "<h1>Accés interdit</h1>";
            ');
            $event->setResponse($response);
            $this->logger->info("Request finished", ['Error Message' => $code]);

        }
    }
}
