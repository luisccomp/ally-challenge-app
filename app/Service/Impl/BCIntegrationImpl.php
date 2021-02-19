<?php

namespace App\Service\Impl;

use App\Service\BCIntegration;
use DateInterval;
use DateTime;

class BCIntegrationImpl implements BCIntegration
{
    private string $url;

    public function __construct()
    {
        $this->url = "http://www4.bcb.gov.br/Download/fechamento/{data}.csv";
    }

    /**
     * Get closing exhange for current day from Banco Central do Brasil.
     */
    public function getClosingExchange()
    {
        $interval = new DateInterval("P1D");

        $date = new DateTime();
        $date = $date->sub($interval);

        // Transform CSV data into an array of pricing information
        $response = file_get_contents(str_replace("{data}", $date->format("Ymd"), $this->url));

        $response = explode("\r\n", $response);

        // Not all currency info array contains size 8, so I decide to exclude them to avoid any
        // unexpected error.
        // $response = array_map(fn ($string) => explode(";", $string), $response);
        $response = array_map(function ($string)
        {
            return explode(";", $string);
        }, $response);

        $response = array_filter($response, fn ($array) => count($array) >= 8);

        // Create a JSON with all currency prices in BRL
        $prices = [];

        foreach ($response as $item)
        {
            $prices[$item[3]] = (int) floatval(str_replace(",", ".", $item[4])) * 100;
        }

        $prices["BRL"] = 1.0;

        return $prices;
    }
}
