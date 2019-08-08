<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 04/08/2019
 * Time: 20:55
 */

namespace App\Entity;


trait EntityTimestamps
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
    * @ORM\Column(type="datetime")
    */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @ORM\PrePersist
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @ORM\PreUpdate
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = new \DateTime();
    }

}