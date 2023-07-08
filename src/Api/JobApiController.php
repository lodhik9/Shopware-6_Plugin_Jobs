<?php
namespace Swag\JobExampleSecond\Api;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Shopware\Core\Framework\Uuid\Uuid;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Swag\JobExampleSecond\Entity\CustomEntity\JobDefinition;
use Shopware\Core\System\Media\MediaEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\MediaNotFoundException;

/**
 * @Route(defaults={"_routeScope"={"api"}})
 */
class JobApiController extends AbstractController
{
    /**
     * @var JobDefinition
     */
    private $jobDefinition;

    /**
     * @var EntityRepository
     */
    private $mediaRepository;
    
//    /**
//     * @var EntityRepository
//     */
//    private $jobRepository;

    public function __construct(
            JobDefinition $jobDefinition,
            EntityRepository $mediaRepository,
//            EntityRepository $jobRepository
            )
    {
        $this->jobDefinition = $jobDefinition;
        $this->mediaRepository = $mediaRepository;
//        $this->jobRepository = $jobRepository;
    }

    /**
     * @Route("/api/v1/_action/swag_job_entity/generate", name="api.custom.swag_job_entity.generate", methods={"POST"})
     * @return Response
     */
    public function generate(Context $context): Response
    {
        $faker = Factory::create();
        $media = $this->getActiveMedia($context);

        $data = [];
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'id' => Uuid::randomHex(),
                'active' => true,
                'title' => $faker->name,
                'description' => $faker->streetAddress,
                'mediaId' => $media->getId(),
            ];
        }

        $jobRepository = $this->container->get('swag_job_entity.repository');
        $jobRepository->create($data, $context);

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Context $context
     * @return MediaEntity
     * @throws MediaNotFoundException
     */
    private function getActiveMedia(Context $context): MediaEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('active', '1'));
        $criteria->setLimit(1);

        $jobRepository = $this->container->get('swag_job_entity.repository');
        $job = $jobRepository->search($criteria, $context)->getEntities()->first();

        if ($job === null) {
            throw new MediaNotFoundException('');
        }

        return $job;
    }

    /**
     * @Route("/api/v{version}/jobs", name="api.job.list", defaults={"auth_enabled"=true}, requirements={"version"="\d+"}, methods={"GET"})
     */
    public function listJobs(Context $context): JsonResponse
    {
        $criteria = new Criteria();
        $jobs = $this->jobDefinition->getRepository()->search($criteria, $context);

        return new JsonResponse($jobs);
    }

    /**
     * @Route("/api/v{version}/jobs/{id}", name="api.job.get", defaults={"auth_enabled"=true}, requirements={"version"="\d+", "id"="\d+"}, methods={"GET"})
     */
    public function getJob(int $id, Context $context): JsonResponse
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $id));
        $job = $this->jobDefinition->getRepository()->search($criteria, $context)->first();

        if (!$job) {
            return new JsonResponse(['message' => 'Job not found'], 404);
        }

        return new JsonResponse($job);
    }
}
