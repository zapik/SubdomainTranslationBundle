<?php

namespace Zapik\SubdomainTranslationBundle;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Zapik\SubdomainTranslationBundle\Switcher;

class KernelRequestListener
{
    protected $translationSwitcher;

    public function __construct(Switcher $translationSwitcher)
    {
        $this->translationSwitcher = $translationSwitcher;
    }

    public function onDomainParse(GetResponseEvent $event)
    {
        if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            if ($response = $this->translationSwitcher->switchLocaleForRequest($event->getRequest())) {
                $event->setResponse($response);
            }
        }
    }
}