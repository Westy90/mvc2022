<?php

namespace App\Controller;
use App\Entity\TrainLibrary;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\TrainLibraryRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainLibraryController extends AbstractController
{
    #[Route('/train/library', name: 'library-home')]
    public function index(): Response
    {
        return $this->render('train_library/index.html.twig', [
            'controller_name' => 'TrainLibraryController',
        ]);
    }





    /**
     * @Route(
     *      "/train/create",
     *      name="create_train",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createTrain(): Response
    {
        return $this->render('train_library/create.html.twig');
    }


    /**
    * @Route("/train/create_process", name="create_train_process")
    */
    public function createTrainProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $train = new TrainLibrary();
        
        $train->setName($request->request->get('name'));
        //$train->setName('Train_' . rand(1, 9));
        $train->setYearMade(rand(100, 999));

        // tell Doctrine you want to (eventually) save the train
        // (no queries yet)
        $entityManager->persist($train);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new train with id '.$train->getId());
    }


    /**
    * @Route("/train/show", name="train_show_all")
    */
    public function showAlltrain(
        TrainLibraryRepository $TrainLibraryRepository
    ): Response {
        $trains = $TrainLibraryRepository
            ->findAll();

        return $this->json($trains);
    }


    /**
     * @Route("/train/show/{id}", name="train_by_id")
     */
    public function showtrainById(
        trainRepository $trainRepository,
        int $id
    ): Response {
        $train = $trainRepository
            ->find($id);

        return $this->json($train);
    }



    /**
     * @Route("/train/delete/{id}", name="train_delete_by_id")
     */
    public function deletetrainById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $train = $entityManager->getRepository(train::class)->find($id);

        if (!$train) {
            throw $this->createNotFoundException(
                'No train found for id '.$id
            );
        }

        $entityManager->remove($train);
        $entityManager->flush();

        return $this->redirectToRoute('train_show_all');
    }


    /**
     * @Route("/train/update/{id}/{value}", name="train_update")
     */
    public function updatetrain(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $train = $entityManager->getRepository(train::class)->find($id);

        if (!$train) {
            throw $this->createNotFoundException(
                'No train found for id '.$id
            );
        }

        $train->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('train_show_all');
    }

}
