<?php

namespace App\EventListener;

use Doctrine\DBAL\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelRequestListener
{
    /**
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if ($request->getMethod() !== 'POST') {
            $response = new Response();
            $response->setContent("
                <h1>Type de requête non autorisé pour le Kernel</h1>
            ");
            $event->setResponse($response);
        }
    }
}
