<?php

namespace App\Entity;

use App\Repository\TemperatureQueryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="temperature_query")
 * @ORM\Entity(repositoryClass=TemperatureQueryRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class TemperatureQuery
{
    public CONST GAS_CONSTANT_VALUE_H = 83.14472;

    public CONST GAS_CONSTANT_VALUE_R = 0.008314472;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var array
     * @ORM\Column(name="json_data", type="json", nullable=true)
     */
    private $jsonData;

    /**
     * @ORM\Column(name="ip_address", type="string", length=50, nullable=true)
     */
    private $ipAddress;

    /**@var float
     * @ORM\Column(name="mkt", type="float", nullable=true)
     */
    private $mkt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * TemperatureQuery constructor.
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setMkt(0.00);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }

    /**
     * @param array|null $jsonData
     *
     * @return $this
     */
    public function setJsonData(?array $jsonData): TemperatureQuery
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMkt(): ?float
    {
        return $this->mkt;
    }

    /**
     * @param float|null $mkt
     *
     * @return $this
     */
    public function setMkt(?float $mkt): TemperatureQuery
    {
        $this->mkt = $mkt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @param string|null $ipAddress
     *
     * @return $this
     */
    public function setIpAddress(?string $ipAddress): TemperatureQuery
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt): TemperatureQuery
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt): TemperatureQuery
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets triggered every time on update
     *
     * @ORM\PreUpdate
     * @return void
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
