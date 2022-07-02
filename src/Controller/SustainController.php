<?php

namespace App\Controller;

use App\Entity\TrainLibrary;

use App\Entity\Overcrowding2;
use App\Repository\Overcrowding2Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\TrainLibraryRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Sustain\Sustain;

//Php office
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

//Charts
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class SustainController extends AbstractController
{
    /**
    * @Route("/proj/reset", name="proj_reset")
    */

    public function resetDatabases(
        ManagerRegistry $doctrine,
        Overcrowding2Repository $Overcrowding2Repository
    ): Response {

        $data = [
            'title' => 'Excel read',
            'dataArray' => Null,
            'firstRow' => Null,
            'lastRow' => Null,
            'test' => "none",
            'infoBox' => "Showing all the trains in the database below. Click on Id # for details for one train",
            'controller_name' => 'TrainLibraryController'
            ];

            $databaseHandler = new Sustain($doctrine, $Overcrowding2Repository);

            $databaseHandler->clearDatabase();
            $databaseHandler->insertIntoDatabase('B13:H21', 2);
            $databaseHandler->insertIntoDatabase('B25:H33', 3);

        $this->addFlash("info", 'The database is now resetted');

        //return $this->render('sustain/read.html.twig', $data);
        return $this->redirectToRoute('proj');
    }


    #[Route('/proj', name: 'proj')]
    public function index(Overcrowding2Repository $Overcrowding2Repository): Response
    {
        $dataArray = $Overcrowding2Repository
            ->findByType("Samtliga 16-84 år");
        //->findAll();



            $firstRow = min(array_keys($dataArray));
            $lastRow = max(array_keys($dataArray));


            $data = [
            'title' => 'Excel read',
            'dataArray' => $dataArray,
            'firstRow' => $firstRow,
            'lastRow' => $lastRow,
            'test' => "none",
            'infoBox' => "Showing all the trains in the database below. Click on Id # for details for one train",
            'controller_name' => 'TrainLibraryController'
        ];

        return $this->render('sustain/read.html.twig', $data);
    }



    #[Route('/chart', name: 'chart')]
    public function chart(
        ChartBuilderInterface $chartBuilder,
        Overcrowding2Repository $Overcrowding2Repository
        ): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $dataArray = $Overcrowding2Repository
        ->findByType("Samtliga 16-84 år");

        foreach ($dataArray as $data) {

            $labels[] = $data->getYear();
            $dataPercentage[0][] = $data->getPercentage();

        }

        $dataArray = $Overcrowding2Repository
        ->findByType("Kvinnor 16-84 år");

        foreach ($dataArray as $data) {
            $dataPercentage[1][] = $data->getPercentage();

        }


        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Samtliga 16-84 år',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $dataPercentage[0],
                ],
                [
                    'label' => 'Kvinnor 16-84 år',
                    'backgroundColor' => 'rgb(0, 18, 102)',
                    'borderColor' => 'rgb(0, 18, 102)',
                    'data' => $dataPercentage[1],
                ],
            ],
        ]);



        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 25,
                ],
            ],
        ]);


        return $this->render('sustain/chart.html.twig', [
            'chart' => $chart,
        ]);
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

        $train = new Overcrowding2(
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
