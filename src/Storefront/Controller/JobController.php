<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class JobController extends StorefrontController
{
    private GenericPageLoaderInterface $genericPageLoader;

    public function __construct(GenericPageLoaderInterface $genericPageLoader) {
        $this->genericPageLoader = $genericPageLoader;
        
    }
    /**
    * @Route("/jobs", name="frontend.jobs", methods={"GET"})
    */
    public function showJobs(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->genericPageLoader->load($request,$context);
//        dd($page);
        return $this->renderStorefront('@SwagJobExampleSecond/storefront/page/jobs.html.twig', [
            'heading' => 'Welcome to Jobs Portal',
            'page' => $page
        ]);
    }
}