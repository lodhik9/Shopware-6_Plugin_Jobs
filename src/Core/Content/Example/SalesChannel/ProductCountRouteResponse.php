<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Core\Content\Example\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\CountResult;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

/**
 * Class CountResult
 * @property CountResult $object
 */
class ProductCountRouteResponse extends StoreApiResponse
{
    public function __construct(CountResult $countResult)
    {
        parent::__construct($countResult);
    }

    public function getProductCount(): CountResult
    {
        return $this->object;
    }
}