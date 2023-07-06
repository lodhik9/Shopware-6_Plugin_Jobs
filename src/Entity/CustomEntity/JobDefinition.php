<?php

namespace Swag\JobExampleSecond\Entity\CustomEntity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinitionConfigurator;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class JobDefinition extends EntityDefinition
{
    public function getEntityName(): string
    {
        return 'swag_job_entity';
    }

    public function getCollectionClass(): string
    {
        return JobCollection::class;
    }

    public function getEntityClass(): string
    {
        return JobEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id','id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('title', 'title'))->setFlags(new Required()),
            (new StringField('description', 'description'))->setFlags(new Required()),
            new FkField('image_id', 'imageId', MediaDefinition::class),
            new OneToOneAssociationField('image', 'image_id', MediaDefinition::class, 'id', false),
            new IntField('age', 'age'),
            new BoolField('active', 'active'),
        ]);
    }

    public static function getDefinitionConfigurator(): EntityDefinitionConfigurator
    {
        return new class implements EntityDefinitionConfigurator {
            public function configure(EntityDefinitionConfigurator $configurator): void
            {
                $configurator->setEntityClass(JobEntity::class);
                $configurator->setEntityName('swag_job_entity');
                $configurator->setInsertMode(EntityDefinitionConfigurator::INSERT_MODE_REPLACE);
            }
        };
    }
}
