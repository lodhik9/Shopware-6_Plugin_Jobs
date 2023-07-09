<?php

namespace Swag\JobExampleSecond\Entity\CustomEntity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class JobRepository extends EntityRepository
{
    public function getDefinitionClass(): string
    {
        return JobDefinition::class;
    }
}
