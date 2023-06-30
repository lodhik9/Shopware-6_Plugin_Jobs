<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class JobController extends StorefrontController
{
    /**
    * @Route("/jobs", name="frontend.jobs", methods={"GET"})
    */
    public function showJobs(): Response
    {
        return $this->renderStorefront('@SwagJobExampleSecond/storefront/page/jobs.html.twig');
    }
}