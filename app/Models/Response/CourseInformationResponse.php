<?php

namespace App\Models\Response;

class CourseInformationResponse
{
    private string $name;
    private int $usd;
    private int $aud;
    private int $eur;
    private int $brl;
    
    public function __construct(string $name, $usd, $aud, $eur, $brl)
    {
        $this->name = $name;
        $this->usd = intval($usd);
        $this->aud = intval($aud);
        $this->eur = intval($eur);
        $this->brl = intval($brl);
    }

    // Defining getters and setters
    public function __get(string $property)
    {
        return $this->$property;
    }

    public function __set(string $property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Serialize object into a map of key value format. This function is required to
     * serialize an object to JSON response.
     */
    public function toResponse(): array
    {
        return [
            "name" => $this->name,
            "USD" => $this->usd,
            "AUD" => $this->aud,
            "EUR" => $this->eur,
            "BRL" => $this->brl
        ];
    }
}