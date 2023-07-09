<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Storefront\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class FooterSubscriber implements EventSubscriberInterface
{
    
    private SystemConfigService $systemConfigService;
    private EntityRepository $jobRepository;
    
    public function __construct(
            SystemConfigService $systemConfigService,
            EntityRepository $jobRepository,
            
    ) 
    {
        $this->systemConfigService = $systemConfigService;
        $this->$jobRepository = $jobRepository;
        
        
    }
    public static function getSubscribedEvents() 
    {
        return [
          FooterPageletLoadedEvent::class => 'onFooterPageletLoaded'  
        ];
        
    }
    
    public function onFooterPageletLoaded(FooterPageletLoadedEvent $event): void
    {
        if(!$this->systemConfigService->get('SwagJobExampleSecond.config.showInStoreront'))
        {
            return;
        }
        
        $shops = $this->fetchShops($event->getContext());
        $event->getPagelet()->addExtension('swag_job_entity.repository', $shops);
    }
    
    /**
     * 
     * @param Context $context
     * @return JobCollection
     */
    private function fetchShops(Context $context): JobCollection
    {
        $criteria = new Criteria();
        $criteria->addAssociation('image');
        
        $criteria->addFilter(new EqualsFilter('active','1'));
        $criteria->setLimit(5);
        
        /** @var   JobCollection $jobCollection       */
        $jobCollection = $this->jobRepository->search($criteria, $context)->getEntities();
        return $jobCollection;
        
        
    }
}

