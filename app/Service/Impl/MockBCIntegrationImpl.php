<?php

namespace App\Service\Impl;

use App\Service\BCIntegration;

class MockBCIntegrationImpl implements BCIntegration
{
    /**
     * This is a mock function that emulates calling to BC API that retrieves a CSV
     * file with closing exchange prices from 2021-02-18.
     */
    public function getClosingExchange()
    {
        $content = file_get_contents("D:\\xampp\\htdocs\\ally-challenge-app\\app\\Service\\Impl\\20210218.csv");
        $content = explode("\r\n", $content);
        
        $response = array_map(fn ($line) => explode(";", $line), $content);
        $response = array_filter($response, fn ($arr) => count($arr) >= 8);

        $prices = [];

        foreach ($response as $item)
        {
            $prices[$item[3]] = floatval(str_replace(",", ".", $item[4])) * 100;
        }

        $prices["BRL"] = 100;

        return $prices;
    }
}