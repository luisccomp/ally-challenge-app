<?php

namespace App\Service;

interface BCIntegration
{
    /**
     * Get closing exhange for current day from Banco Central do Brasil.
     */
    public function getClosingExchange();
}