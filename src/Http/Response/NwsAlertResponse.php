<?php

namespace NationalWeatherServiceApi\Http\Client;

use Cake\Http\Client\Response;
use NationalWeatherServiceApi\Http\Model\NwsAlert;

final class NwsAlertResponse extends Response
{
    private $alerts;
    private $title;
    private $updated;
    private $nextPage;

    public function __construct($headers, $body)
    {
        parent::__construct($headers, $body);

        $jsonBody = $this->getJson();

        foreach ($jsonBody->{'@graph'} as $rawAlert) {
            $alert = new NwsAlert($rawAlert);
            array_push($this->alerts, $alert);
        }
    }

    public function getAlerts()
    {
        return $this->alerts;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUpdatedDateTime()
    {
        return $this->updated;
    }

    public function getNextPageResultsUrl()
    {
        return $this->nextPage;
    }
}