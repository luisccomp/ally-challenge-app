<?php

namespace App\Http\Controllers;

use App\Models\Response\CourseInformationResponse;
use App\Service\AllyIntegration;
use App\Service\BCIntegration;
use Illuminate\Http\Request;

class AllyCourseController extends Controller
{
    private BCIntegration $bCIntegration;
    private AllyIntegration $allyIntegration;

    public function __construct(BCIntegration $bCIntegration, AllyIntegration $allyIntegration)
    {
        $this->bCIntegration = $bCIntegration;
        $this->allyIntegration = $allyIntegration;
    }

    public function getCoursePrices()
    {
        // Retrieving all closing exchanges from BC and ally course information from
        // external API with integration.
        $closingExchangeInfo = $this->bCIntegration->getClosingExchange();
        $coursesPriceInfo = $this->allyIntegration->getAllyCourseInformation();

        $this->convertPrices($coursesPriceInfo[0], $closingExchangeInfo);

        // return $this->bCIntegration->getClosingExchange();
        // return array_map(fn ($courePriceInfo) => $courePriceInfo->toResponse(), $coursesPriceInfo);
        return array_map(
            fn ($coursePriceInfo) => $this->convertPrices($coursePriceInfo, $closingExchangeInfo)->toResponse(),
            $coursesPriceInfo
        );
    }

    // Convert courses prices
    private function convertPrices(CourseInformationResponse $courseInformation, array $closingExchangeInfo)
    {
        // Get price of given courses and convert them
        $currency = "";
        $value = 0;

        // Since at least one of currencies contains a price, then stop when find it
        foreach (["USD", "AUD", "EUR", "BRL"] as $currencyName)
        {
            $courseInfo = $courseInformation->toResponse();
            if ($courseInfo[$currencyName] != 0)
            {
                $currency = $currencyName;
                $value = $courseInfo[$currencyName];

                break;
            }
        }

        $brlPrice = $value * $closingExchangeInfo[$currencyName];
        $usdPrice = $brlPrice / $closingExchangeInfo["USD"];
        $audPrice = $brlPrice / $closingExchangeInfo["AUD"];
        $eurPrice = $brlPrice / $closingExchangeInfo["EUR"];

        $courseInformation->usd = $usdPrice;
        $courseInformation->aud = $audPrice;
        $courseInformation->eur = $eurPrice;
        $courseInformation->brl = $brlPrice * .01;

        return $courseInformation;
    }

}
