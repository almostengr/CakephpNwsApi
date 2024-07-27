<?php
declare(strict_types=1);

namespace NationalWeatherServiceApi\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Http\Client;
use NationalWeatherServiceApi\Model\Enum\ZoneType;

/**
 * NwsApi component
 */
class NwsApiComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];

    protected $httpClient;

    private function formatCoordinates(string $xCoordinate, string $yCoordinate)
    {
        $xCoord = (string) number_format(floatval($xCoordinate), 4);
        $yCoord = (string) number_format(floatval($yCoordinate), 4);

        return "$xCoord,$yCoord";
    }

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

    public function getAllAlerts()
    {
        return $this->httpClient->get("/alerts");
    }

    public function getActiveAlerts()
    {
        return $this->httpClient->get("/alerts/active");
    }

    public function getActiveAlertCount()
    {
        return $this->httpClient->get("/alerts/active/count");
    }

    public function getActiveAlertsByZone(string $zoneId)
    {
        return $this->httpClient->get("/alerts/active/zone/$zoneId");
    }

    public function getActiveAlertsByArea(string $areaId)
    {
        return $this->httpClient->get("/alerts/active/area/$areaId");
    }

    public function getActiveAlertsByRegion(string $regionId)
    {
        return $this->httpClient->get("/alerts/active/region/$regionId");
    }

    public function getAlertTypes()
    {
        return $this->httpClient->get("/alerts/types");
    }

    public function getAlertById(string $alertId)
    {
        return $this->httpClient->get("/alerts/$alertId");
    }

    public function getCenterWeatherServiceUnit(string $cwsuId)
    {
        return $this->httpClient->get("/aviation/cwsus/$cwsuId");
    }

    public function getCenterWeatherAdvisories(string $cwsuId)
    {
        return $this->httpCleint->get("/aviation/cwsus/$cwsuId/cwas");
    }

    public function getGlossary()
    {
        return $this->httpClient->get("/glossary");
    }

    public function getRawForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates");
    }

    public function getTextForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/forecast");
    }

    public function getHourlyTextForecastData(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/forecast");
    }

    public function getStationsByCoordinates(string $forecastOfficeId, string $xCoordinate, string $yCoordinate)
    {
        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/gridpoints/$forecastOfficeId/$coordinates/stations");
    }

    public function getObservationsByStationId(string $stationId)
    {
        return $this->httpClient->get("/stations/$stationId/observations");
    }

    public function getLatestObservationByStationId(string $stationId)
    {
        return $this->httpClient->get("/stations/$stationId/observations/latest");
    }

    public function getTerminalAerodromeForecastsByStationId(string $stationId)
    {
        return $this->httpClient->get("/stations/$stationId/tafs");
    }

    public function getAllObservationStations()
    {
        return $this->httpClient->get("/stations");
    }

    public function getObservationStationMetaData(string $stationId)
    {
        return $this->httpClient->get("/stations/$stationId");
    }

    public function getWeatherOfficeMetaData(string $officeId)
    {
        return $this->httpClient->get("/offices/$officeId");
    }

    public function getWeatherOfficeHeadlines($officeId)
    {
        return $this->httpClient->get("/offices/$officeId");
    }

    public function getPointMetaData($xCoordinate, $yCoordinate)
    {
        $coordinates = $this->formatCoordinates($xCoordinate, $yCoordinate);
        return $this->httpClient->get("/points/$coordinates");
    }

    public function getZones()
    {
        return $this->httpClient->get("/zones");
    }

    public function getZonesByType(ZoneType $type)
    {
        return $this->httpClient->get("/zones/$type->value");
    }

    public function getObservationsByZone($zoneId)
    {
        return $this->httpClient->get("/zones/forecast/$zoneId/observations");
    }

    public function getObservationStationsByZone($zoneId)
    {
        return $this->httpClient->get("/zones/forecast/$zoneId/stations");
    }
}
