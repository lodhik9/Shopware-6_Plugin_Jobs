<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Service;

use Shopware\Storefront\Pagelet\Footer\FooterPageletLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Swag\JobExampleSecond\Core\Content\Example\SalesChannel\ProductCountRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class AddDataToPage implements EventSubscriberInterface
{
    private ProductCountRoute $productCountRoute;

    public function __construct(ProductCountRoute $productCountRoute)
    {
        $this->productCountRoute = $productCountRoute;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FooterPageletLoadedEvent::class => 'addActiveProductCount'
        ];
    }

    public function addActiveProductCount(FooterPageletLoadedEvent $event): void
    {
        $productCountResponse = $this->productCountRoute->load(new Criteria(), $event->getSalesChannelContext());

        $event->getPagelet()->addExtension('product_count', $productCountResponse->getProductCount());
    }
}