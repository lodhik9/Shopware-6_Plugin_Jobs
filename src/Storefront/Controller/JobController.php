<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Content\Media\MediaService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Shopware\Core\Content\Media\File\MediaFile;
use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class JobController extends StorefrontController
{
      private GenericPageLoaderInterface $genericPageLoader;
    private SystemConfigService $systemConfigService;
    private EntityRepository $mediaRepository;
    private MediaService $mediaService;
    private FileSaver $fileSaver;

    public function __construct(
        GenericPageLoaderInterface $genericPageLoader,
        SystemConfigService $systemConfigService,
        EntityRepository $mediaRepository,
        MediaService $mediaService,
        FileSaver $fileSaver
    ) {
        $this->genericPageLoader = $genericPageLoader;
        $this->systemConfigService = $systemConfigService;
        $this->mediaRepository = $mediaRepository;
        $this->mediaService = $mediaService;
        $this->fileSaver = $fileSaver;
    }
    /**
    * @Route("/jobs", name="frontend.jobs", methods={"GET"})
    */
    public function showJobs(Request $request, SalesChannelContext $salesChannelContext, Context $context): Response
    {
        $page = $this->genericPageLoader->load($request, $salesChannelContext);
        $jobPageHeading = $this->systemConfigService->get('SwagJobExampleSecond.config.jobPageHeading' );
        $jobPageImageId = $this->systemConfigService->get('SwagJobExampleSecond.config.jobPageMedia' );

//        dd($jobPageImage);
        $criteria = new Criteria([$jobPageImageId]);
//        $criteria->addFilter(new EqualsFilter('name', 'Example name'));

        $medias = $this->mediaRepository->search($criteria, $context)->first();
//       dd($medias->getUrl());
    
        return $this->renderStorefront('@SwagJobExampleSecond/storefront/page/jobs.html.twig', [
            'heading' => $jobPageHeading,
            'imagePath' => $medias->getUrl(),
            'page' => $page
        ]);
    }
    
    /**
     * @Route("/jobs/create" , name="frontend.jobs.create" , methods={"POST"})
     */
    public function createJob(Request $request, SalesChannelContext $salesChannelContext, Context $context): Response
    {
        $formData = $request->request->all();
        $jobTitle = $formData['title'];
        $jobDescription = $formData['description'];
        $uploadedFile = $request->files->get('image');
        $folder = 'default'; // Replace with your desired folder name
        $type = 'image/*'; // Replace with the appropriate file type
        $mediaId = null;
        
        if($uploadedFile instanceof UploadedFile){
            $mediaId = $this->uploadFile($uploadedFile,$folder,$type, $context);
        }
        $jobEntity = [
            'title' => $jobTitle,
            'description' => $jobDescription,
            'imageId' => $mediaId,
        ];
        
//        dd($mediaId);
        
        $this->mediaRepository->create([$jobEntity], $context);
        
        // Add success flash message
    $this->addFlash('success', 'Job created successfully!');
    
        return $this->redirectToRoute('frontend.jobs.show_all');
    
        
    }
    
    /**
 * @Route("/jobs/showall", name="frontend.jobs.show_all", methods={"GET"})
 */
public function showAllJobs(SalesChannelContext $salesChannelContext, Context $context): Response
{
    // Retrieve all jobs from the repository
    $criteria = new Criteria();
     $criteria->addAssociation('image');
    $jobs = $this->mediaRepository->search($criteria, $context)->getEntities();

//   dd($jobs);
    
    // Render the jobs list view
    return $this->renderStorefront('@SwagJobExampleSecond/storefront/page/show_all_jobs.html.twig', [
        'jobs' => $jobs,
    ]);
}

    
  private function uploadFile(UploadedFile $file, string $folder, string $type, Context $context): ?string
{
//       $this->checkValidFile($file);

//        $this->validator->validate($file, $type);

        $mediaFile = new MediaFile($file->getPathname(), $file->getMimeType(), $file->getClientOriginalExtension(), $file->getSize());

        $mediaId = $this->mediaService->createMediaInFolder($folder, $context, false);

        try {
            $this->fileSaver->persistFileToMedia(
                $mediaFile,
                pathinfo($file->getFilename(), PATHINFO_FILENAME),
                $mediaId,
                $context
            );
        } catch (MediaNotFoundException $e) {
            throw new UploadException($e->getMessage());
        }

        return $mediaId;
        
//    $fileName = uniqid('', true) . '.' . $file->getClientOriginalExtension();
//
//    // Retrieve the default folder for media
//    $defaultFolder = $this->mediaService->getMediaDefaultFolderIdPublic('default',$context);
//
//    // Check if the default folder is found
//    if ($defaultFolder instanceof MediaFolderEntity) {
//        // Use the folder ID as a string for the first argument
//        $folderId = $defaultFolder->getId();
//
//        $mediaId = $this->mediaService->createMediaInFolder(
//            $folderId,
//            new File($file->getPathname()),
//            $context,
//            $fileName
//        );
//        
////        // Upload the file using the MediaService
////$mediaId = $this->mediaService->createMediaInFolder(
////    new File($file->getPathname()),
////    $context,
////    $defaultFolderId, // Pass the default folder ID
////    'jobs', // Folder name where the media should be stored
////    $fileName
////);
//
//        return $mediaId;
//    }
//
//    return null;
}


  /**
     * @Route("/jobs/{id}", name="frontend.jobs.update", methods={"PUT"})
     */
    public function updateJob(Request $request, string $id): Response
    {
        // Fetch the existing job entity
        $job = $this->jobRepository->search(new Criteria([$id]), $context)->first();

        if (!$job) {
            // Handle case where job entity with the given ID is not found
            // Return an appropriate response or throw an exception
        }

        // Handle the update request
        $requestData = json_decode($request->getContent(), true);

        // Update the job entity with the new data
        $job->setTitle($requestData['title']);
        $job->setDescription($requestData['description']);

        // Validate the updated entity
        // You can use validation constraints or custom validation logic here
        $validationErrors = $validator->validate($job);

        if (count($validationErrors) > 0) {
            // Handle validation errors
            // Return an appropriate response or throw an exception
        }

        // Save the updated entity
        $this->jobRepository->update([$job], $context);

        // Provide feedback to the user
        return new Response('Job updated successfully', Response::HTTP_OK);
    }
}