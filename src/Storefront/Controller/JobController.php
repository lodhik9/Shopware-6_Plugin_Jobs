<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class JobController extends StorefrontController
{
    private GenericPageLoaderInterface $genericPageLoader;
    private SystemConfigService $systemConfigService;

    public function __construct(GenericPageLoaderInterface $genericPageLoader, SystemConfigService $systemConfigService) {
        $this->genericPageLoader = $genericPageLoader;
        $this->systemConfigService = $systemConfigService;
        
    }
    /**
    * @Route("/jobs", name="frontend.jobs", methods={"GET"})
    */
    public function showJobs(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->genericPageLoader->load($request,$context);
//        dd($page);
        $jobPageConfig = $this->systemConfigService->get('SwagJobExampleSecond.config.jobPageHeading' );
       
        return $this->renderStorefront('@SwagJobExampleSecond/storefront/page/jobs.html.twig', [
            'heading' => $jobPageConfig,
            'page' => $page
        ]);
    }
}