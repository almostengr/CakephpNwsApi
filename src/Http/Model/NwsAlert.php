<?php

namespace NationalWeatherServiceApi\Http\Model;

final class NwsAlert
{
    private $id;
    private $areaDescription;
    private $geometry;
    private $geocodeSame;
    private $geocodeUgc;
    private $affectedZones;
    private $sent;
    private $effective;
    private $onSet;
    private $expires;
    private $ends;
    private $status;
    private $messageType;
    private $category;
    private $severity;
    private $certainty;
    private $urgency;
    private $event;
    private $sender;
    private $senderName;
    private $headline;
    private $description;
    private $instruction;
    private $response;

    public function __construct(object $jsonObject)
    {
        if (!empty($jsonObject->id)) {
            $this->id = $jsonObject->id;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAreaDescription()
    {
        return $this->areaDescription;
    }

    public function getGeometry()
    {
        return $this->geometry;
    }

    public function getAffectedZones()
    {
        return $this->affectedZones;
    }

    public function getSent()
    {
        return $this->sent;
    }

    public function getEffectiveDateTime()
    {
        return $this->effective;
    }
    
    public function getOnSet()
    {
        return $this->onSet;
    }

    public function getExpires()
    {
        return $this->expires;
    }
    
    public function getEndDateTime()
    {
        return $this->ends;
    }
}