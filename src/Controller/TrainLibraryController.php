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
    /**
    * @Route("/train/reset", name="reset_train")
    */
    public function resetTrain(
        ManagerRegistry $doctrine,
        TrainLibraryRepository $TrainLibraryRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $trains = $TrainLibraryRepository
        ->findAll();

        foreach ($trains as $train) {
            $entityManager->remove($train);
        }
        //$entityManager->flush();

        $newTrains[0] = new TrainLibrary("C2", 280, 1949, 1961, 1999, "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Sp%C3%A5rv%C3%A4gsmuseet_-SL_C2_2417.JPG/800px-Sp%C3%A5rv%C3%A4gsmuseet_-SL_C2_2417.JPG?20150206134530");
        $newTrains[1] = new TrainLibrary("C6", 160, 1970, 1974, 2022, "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/SL_C6_2701_vid_Ropsten.jpg/1920px-SL_C6_2701_vid_Ropsten.jpg");
        $newTrains[2] = new TrainLibrary("C20F", 1, 2003, 2003, 0, "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/SL_C20F_04.jpg/745px-SL_C20F_04.jpg");

        // tell Doctrine you want to (eventually) save the train
        // (no queries yet)

        foreach ($newTrains as $newTrain) {
            $entityManager->persist($newTrain);
        }

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash("info", 'The database is now resetted');

        return $this->redirectToRoute('library-home');
    }


    #[Route('/train/library', name: 'library-home')]
    public function index(TrainLibraryRepository $TrainLibraryRepository): Response
    {
        $trains = $TrainLibraryRepository
            ->findAll();

        $data = [
            'title' => 'Train Library - Home',
            'trains' => $trains,
            'infoBox' => "Showing all the trains in the database below. Click on Id # for details for one train",
            'controller_name' => 'TrainLibraryController'
        ];

        return $this->render('train_library/home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/train/create",
     *      name="create_train",
     *      methods={"GET","HEAD"}
     * )
     */
    public function createTrain(

    ): Response {

        $data = [
            'title' => 'Train Library - Create',
            'action' => "create_process",
            'formTitle' => "Create",
            'trains' => [new TrainLibrary()], //Dummy train för att använda samma vy i C och U
            'controller_name' => 'TrainLibraryController'
        ];

        return $this->render('train_library/create.html.twig', $data);
    }

    /**
    * @Route("/train/create_process", name="create_train_process")
    */
    public function createTrainProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $train = new TrainLibrary(
            $request->request->get('name'),
            intval($request->request->get('amountMade')),
            intval($request->request->get('yearMade')),
            intval($request->request->get('lastYearMade')),
            intval($request->request->get('exitService')),
            $request->request->get('picture')
        );

        // tell Doctrine you want to (eventually) save the train
        // (no queries yet)
        $entityManager->persist($train);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash("info", 'Saved new train with id ' . $train->getId());

        return $this->redirectToRoute('library-home');
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
        int $id,
        TrainLibraryRepository $TrainLibraryRepository
    ): Response {
        $train = $TrainLibraryRepository
            ->find($id);

        $data = [
        'title' => 'Train Library - Details for one train',
        'trains' => [$train],
        'infoBox' => "Showing details for one train.",
        'controller_name' => 'TrainLibraryController'

        ];

        return $this->render('train_library/home.html.twig', $data);
    }

    /**
     * @Route("/train/delete/{id}", name="train_delete_by_id")
     */
    public function deletetrainById(
        ManagerRegistry $doctrine,
        TrainLibraryRepository $TrainLibraryRepository,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $train = $TrainLibraryRepository
        ->find($id);

        if (!$train) {
            throw $this->createNotFoundException(
                'No train found for id ' . $id
            );
        }

        $this->addFlash("info", 'Train with id ' . $train->getId() . ' has been deleted');

        $entityManager->remove($train);
        $entityManager->flush();

        return $this->redirectToRoute('library-home');
    }


    /**
     * @Route(
     *      "/train/update/{id}",
     *      name="train_update",
     *      methods={"GET","HEAD"}
     * )
     */
    public function updateTrain(
        ManagerRegistry $doctrine,
        TrainLibraryRepository $TrainLibraryRepository,
        int $id
    ): Response {
        $train = $TrainLibraryRepository
        ->find($id);

        $data = [
            'title' => 'Train Library - Update',
            'action' => "update_process",
            'trains' => [$train],
            'formTitle' => "update",
            'toUpdate' => $id,
            'controller_name' => 'TrainLibraryController'
        ];

        return $this->render('train_library/create.html.twig', $data);
    }

    /**
    * @Route("/train/update/update_process", name="update_process")
    */
    public function updateTrainProcess(
        ManagerRegistry $doctrine,
        Request $request,
        TrainLibraryRepository $TrainLibraryRepository
    ): Response {
        $entityManager = $doctrine->getManager();
        $train = $TrainLibraryRepository
        ->find($request->request->get('id'));

        $train->setName($request->request->get('name'));
        $train->setAmountMade($request->request->get('amountMade'));
        $train->setYearMade($request->request->get('yearMade'));
        $train->setLastYearMade($request->request->get('lastYearMade'));
        $train->setExitService($request->request->get('exitService'));
        $train->setPicture($request->request->get('picture'));

        // tell Doctrine you want to (eventually) save the train
        // (no queries yet)
        $entityManager->persist($train);

        $entityManager->flush();

        $this->addFlash("info", 'Train with id ' . $train->getId() . ' has been update');

        return $this->redirectToRoute('library-home');
    }
}
