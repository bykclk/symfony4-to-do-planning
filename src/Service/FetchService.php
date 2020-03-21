<?php


namespace App\Service;


class FetchService
{
    /** @var FetcherInterface */
    private $providerService;

    public function setProvider($provider)
    {
        $this->providerService = FetcherFactory::create($provider);

        return $this;
    }

    public function fetch()
    {
        return $this->providerService->getTasks();
    }
}