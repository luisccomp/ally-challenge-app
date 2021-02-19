<?php

namespace App\Service\Impl;

use App\Service\AllyIntegration;
use App\Models\Response\CourseInformationResponse;

class AllyIntegrationImpl implements AllyIntegration
{
    private string $url = "https://exports.allyhub.co/";

    public function __construct()
    {        
    }

    public function getAllyCourseInformation(): array
    {
        $response = file_get_contents($this->url);

        return array_map(
            fn ($item) => new CourseInformationResponse(
                $item->name,
                $item->USD,
                $item->AUD,
                $item->EUR,
                $item->BRL
            ),
            (array) json_decode($response)
        );
    }
}