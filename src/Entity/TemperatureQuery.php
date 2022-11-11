<?php

namespace App\Entity;

use App\Repository\TemperatureQueryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="temperature_query")
 * @ORM\Entity(repositoryClass=TemperatureQueryRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @SWG\Definition(type="object", @SWG\Xml(name="TemperatureQuery"))
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
     * @ORM\Column(name="json_data", type="json_array", nullable=true)
     */
    private $jsonData;

    /**
     * @ORM\Column(name="ip_address", type="string", length=50, nullable=true)
     */
    private $ipAddress;

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
    public function setJsonData(?array $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
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
    public function setCreatedAt(\DateTime $createdAt): self
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
    public function setUpdatedAt(\DateTime $updatedAt): self
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
