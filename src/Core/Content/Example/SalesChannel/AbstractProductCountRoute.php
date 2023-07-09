<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Core\Content\Example\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"store-api"}})
 */
abstract class AbstractProductCountRoute
{
    abstract public function getDecorated(): AbstractProductCountRoute;

    abstract public function load(Criteria $criteria, SalesChannelContext $context): ProductCountRouteResponse;
}
