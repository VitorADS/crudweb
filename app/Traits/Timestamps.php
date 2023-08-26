<?php

namespace App\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

trait Timestamps
{
    /**
     * @var DateTime
     */
    #[ORM\Column(name: 'createdAt', type:'datetime', nullable: false, options:['default' => 'CURRENT_TIMESTAMP'])]
    private $createdAt;

    /**
     * @var DateTime
     */
    #[ORM\Column(name: 'updatedAt', type:'datetime', nullable: true)]
    private $updatedAt;

    /**
     * @var DateTime
     */
    #[ORM\Column(name: 'deletedAt', type:'datetime', nullable: true)]
    private $deletedAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @return void
     */
    public function setDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return void
     */
    #[PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return void
     */
    #[PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}