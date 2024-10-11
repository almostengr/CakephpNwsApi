<?php

declare(strict_types=1);

namespace NationalWeatherServiceApi\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;
use NationalWeatherServiceApi\Http\Client\NwsAlertResponse;
use NationalWeatherServiceApi\Model\Enum\ZoneType;

/**
 * NwsApi component
 * 
 * @var Cake\Http\Client $httpClient
 */
final class NwsApiComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];

    protected $httpClient;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->httpClient = new Client([
            "host" => Configure::read("NwsApi.url", "api.weather.gov"),
            "scheme" => "https",
            "headers" => [
                "Accept" => "application/ld+json",
                "Content-Type" => "application/json",
                "Connection" => "keep-alive",
            ],
            "timeout" => Configure::read("NwsApi.timeout", 15),
        ]);
    }

    private function formatCoordinates(string $xCoordinate, string $yCoordinate): string
    {
        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordinates");
        }

        $xCoord = (string) number_format(floatval($xCoordinate), 4);
        $yCoord = (string) number_format(floatval($yCoordinate), 4);

        return "$xCoord,$yCoord";
    }

    private function isNullOrEmpty($value): bool
    {
        return is_null($value) || empty($value);
    }

    public function getAllAlerts()
    {
        $result = $this->httpClient->get("/alerts");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getActiveAlerts()
    {
        $result = $this->httpClient->get("/alerts/active");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getActiveAlertCount()
    {
        $result = $this->httpClient->get("/alerts/active/count");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getActiveAlertsByZone(string $zoneId)
    {
        if ($this->isNullOrEmpty($zoneId)) {
            throw new BadRequestException("Invalid Zone ID");
        }

        $result = $this->httpClient->get("/alerts/active/zone/$zoneId");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getActiveAlertsByArea(string $areaId)
    {
        if ($this->isNullOrEmpty($areaId)) {
            throw new BadRequestException("Invalid Area ID");
        }

        $result = $this->httpClient->get("/alerts/active/area/$areaId");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getActiveAlertsByRegion(string $regionId)
    {
        if ($this->isNullOrEmpty($regionId)) {
            throw new BadRequestException("Invalid Region ID");
        }

        $result = $this->httpClient->get("/alerts/active/region/$regionId");

        if ($result->isSuccess()) {
            return new NwsAlertResponse($result->getHeaders(), $result->getStringBody());
        }

        return $result;
    }

    public function getAlertTypes()
    {
        return $this->httpClient->get("/alerts/types");
    }

    public function getAlertById(string $alertId)
    {
        if ($this->isNullOrEmpty($alertId)) {
            throw new BadRequestException("Invalid alert ID");
        }

        return $this->httpClient->get("/alerts/$alertId");
    }

    public function getCenterWeatherServiceUnit(string $cwsuId)
    {
        if ($this->isNullOrEmpty($cwsuId)) {
            throw new BadRequestException(("Invalid CWSID"));
        }

        return $this->httpClient->get("/aviation/cwsus/$cwsuId");
    }

    public function getCenterWeatherAdvisories(string $cwsuId)
    {
        if ($this->isNullOrEmpty($cwsuId)) {
            throw new BadRequestException(("Invalid CWSID"));
        }

        return $this->httpCleint->get("/aviation/cwsus/$cwsuId/cwas");
    }

    public function getGlossary()
    {
        return $this->httpClient->get("/glossary");
    }

    public function getRawForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        if ($this->isNullOrEmpty($forecastOfficeId)) {
            throw new BadRequestException("Invalid forecast office ID");
        }

        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordinates");
        }

        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates");
    }

    public function getTextForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        if ($this->isNullOrEmpty($forecastOfficeId)) {
            throw new BadRequestException("Invalid forecast office ID");
        }

        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordinates");
        }

        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/forecast");
    }

    public function getHourlyTextForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        if ($this->isNullOrEmpty($forecastOfficeId)) {
            throw new BadRequestException("Invalid forecast office ID");
        }

        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordinates");
        }

        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/forecast");
    }

    public function getStationsByCoordinates(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        if ($this->isNullOrEmpty($forecastOfficeId)) {
            throw new BadRequestException("Invalid forecast office ID");
        }

        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordinates");
        }

        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/stations");
    }

    public function getObservationsByStationId(string $stationId)
    {
        if ($this->isNullOrEmpty($stationId)) {
            throw new BadRequestException("Invalid station ID");
        }

        return $this->httpClient->get("/stations/$stationId/observations");
    }

    public function getLatestObservationByStationId(string $stationId)
    {
        if ($this->isNullOrEmpty($stationId)) {
            throw new BadRequestException("Invalid station ID");
        }

        return $this->httpClient->get("/stations/$stationId/observations/latest");
    }

    public function getTerminalAerodromeForecastsByStationId(string $stationId)
    {
        if ($this->isNullOrEmpty($stationId)) {
            throw new BadRequestException("Invalid station ID");
        }

        return $this->httpClient->get("/stations/$stationId/tafs");
    }

    public function getAllObservationStations()
    {
        return $this->httpClient->get("/stations");
    }

    public function getObservationStationMetaData(string $stationId)
    {
        if ($this->isNullOrEmpty($stationId)) {
            throw new BadRequestException("Invalid station ID");
        }

        return $this->httpClient->get("/stations/$stationId");
    }

    public function getWeatherOfficeMetaData(string $officeId)
    {
        if ($this->isNullOrEmpty($officeId)) {
            throw new BadRequestException("Invalid office ID");
        }

        return $this->httpClient->get("/offices/$officeId");
    }

    public function getWeatherOfficeHeadlines(string $officeId)
    {
        if ($this->isNullOrEmpty($officeId)) {
            throw new BadRequestException("Invalid office ID");
        }

        return $this->httpClient->get("/offices/$officeId");
    }

    public function getPointMetaData($xCoordinate, $yCoordinate)
    {
        if ($this->isNullOrEmpty($xCoordinate) || $this->isNullOrEmpty($yCoordinate)) {
            throw new BadRequestException("Invalid coordintes");
        }

        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/points/$coordinates");
    }

    public function getZones()
    {
        return $this->httpClient->get("/zones");
    }

    public function getZonesByType(ZoneType $type)
    {
        if ($this->isNullOrEmpty($type)) {
            throw new BadRequestException("Zone ID was not provided.");
        }

        return $this->httpClient->get("/zones/$type->value");
    }

    public function getObservationsByZone(string $zoneId)
    {
        if ($this->isNullOrEmpty($zoneId)) {
            throw new BadRequestException("Zone ID was not provided.");
        }

        return $this->httpClient->get("/zones/forecast/$zoneId/observations");
    }

    public function getObservationStationsByZone(string $zoneId)
    {
        return $this->httpClient->get("/zones/forecast/$zoneId/stations");
    }
}
