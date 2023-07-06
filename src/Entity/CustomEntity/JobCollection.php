<?php

namespace Swag\JobExampleSecond\Entity\CustomEntity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(JobCollection $entity)
 * @method void              set(string $key, JobCollection $entity)
 * @method JobCollection[]    getIterator()
 * @method JobCollection[]    getElements()
 * @method JobCollection|null get(string $key)
 * @method JobCollection|null first()
 * @method JobCollection|null last()
 */
class JobCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return JobEntity::class;
    }
}
