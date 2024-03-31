<?php

namespace App\Application\Activity\Find;

class FindActivitiesServiceRequest
{
    private string $type;

    private string $name;

    private string $description;

    private string $platform;

    private string $equipment;

    private string $sportsType;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function hasType(): bool
    {
        return isset($this->type) && !empty($this->type);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function hasName(): bool
    {
        return isset($this->name) && !empty($this->name);
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function hasDescription(): bool
    {
        return isset($this->description) && !empty($this->description);
    }


    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    public function hasPlatform(): bool
    {
        return isset($this->platform) && !empty($this->platform);
    }


    public function getEquipment(): string
    {
        return $this->equipment;
    }

    public function setEquipment(string $equipment): void
    {
        $this->equipment = $equipment;
    }

    public function hasEquipment(): bool
    {
        return isset($this->equipment) && !empty($this->equipment);
    }


    public function getSportsType(): string
    {
        return $this->sportsType;
    }

    public function setSportsType(string $sportsType): void
    {
        $this->sportsType = $sportsType;
    }

    public function hasSportsType(): bool
    {
        return isset($this->sportsType) && !empty($this->sportsType);
    }
}
