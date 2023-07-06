<?php

namespace Swag\JobExampleSecond\Entity\CustomEntity;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class JobEntity extends Entity
{
    use EntityIdTrait; // Include the EntityIdTrait for ID handling

    /**
     * @var string|null
     */
    protected ?string $title;

    /**
     * @var string|null
     */
    protected ?string $description;

    /**
     * @var int|null
     */
    protected ?int $age;

    /**
     * @var bool|null
     */
    protected ?bool $active;

    /**
     * Get the title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title.
     *
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description.
     *
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the age.
     *
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Set the age.
     *
     * @param int|null $age
     */
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    /**
     * Check if the job is active.
     *
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * Set the active status.
     *
     * @param bool|null $active
     */
    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    // Add more getter/setter methods for other properties if needed
}
