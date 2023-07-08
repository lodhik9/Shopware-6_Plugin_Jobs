<?php

namespace Swag\JobExampleSecond\Core\Content\Job;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class JobRepository extends EntityRepository
{
    public function getDefinitionClass(): string
    {
        return JobDefinition::class;
    }
}
