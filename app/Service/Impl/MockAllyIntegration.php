<?php

namespace App\Service\Impl;

use App\Models\Response\CourseInformationResponse;
use App\Service\AllyIntegration;

class MockAllyIntegration implements AllyIntegration
{
    public function getAllyCourseInformation(): array
    {
        $data = [
            [
                "name" => "Course 1",
                "USD" => 1250,
                "AUD" => "",
                "EUR" => "",
                "BRL" => ""
            ],
            [
                "name" => "Course 2",
                "USD" => "",
                "AUD" => 475,
                "EUR" => "",
                "BRL" => ""
            ],
            [
                "name" => "Course 3",
                "USD" => "",
                "AUD" => "",
                "EUR" => "",
                "BRL" => 3200
            ],
            [
                "name" => "Course 4",
                "USD" => "",
                "AUD" => "",
                "EUR" => 800,
                "BRL" => ""
            ]
        ];

        return array_map(fn ($course) => new CourseInformationResponse(
            $course["name"],
            $course["USD"],
            $course["AUD"],
            $course["EUR"],
            $course["BRL"]
        ), $data);
    }
}