<?php
declare(strict_types=1);

namespace NationalWeatherServiceApi\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

/**
 * ZoneType Enum
 */
enum ZoneType: string implements EnumLabelInterface
{
    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }

    case Land = "land";
    case Marine = "marine";
    case Forecast = "forecast";
    case Public = "public";
    case Coastal = "coastal";
    case OffShore = "offshore";
    case Fire = "fire";
    case County = "county";
}
