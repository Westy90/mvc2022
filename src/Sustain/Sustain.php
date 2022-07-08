<?php

namespace App\Sustain;

use App\Sustain\Sustain;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Overcrowding2;
use App\Repository\Overcrowding2Repository;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


//Charts
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class Sustain
{


    protected ManagerRegistry $doctrine;
    protected Overcrowding2Repository $Overcrowding2Repository;
    protected ChartBuilderInterface $chartBuilder;

    /**
    * DiffManager constructor.
    * @param ManagerRegistry $doctrine
    * @param Overcrowding2Repository $Overcrowding2Repository
    */
    public function __construct(ManagerRegistry $doctrine, Overcrowding2Repository $Overcrowding2Repository, ChartBuilderInterface $chartBuilder = Null)
    {
        $this->doctrine = $doctrine;
        $this->Overcrowding2Repository = $Overcrowding2Repository;
        $this->chartBuilder = $chartBuilder;
    }


    public function clearDatabase() {
        $entityManager = $this->doctrine->getManager();

        $overcrowding = $this->Overcrowding2Repository
        ->findAll();

        foreach ($overcrowding as $overcrowd) {
            $entityManager->remove($overcrowd);
        }
    }

    public function insertIntoDatabase(
        $range,
        $norm
    ) {

        $entityManager = $this->doctrine->getManager();

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("mal11.xlsx");

        $dataArray = $spreadsheet->getSheetByName('11.1.2 (N)')
        ->rangeToArray(
        $range,     // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        FALSE         // Should the array be indexed by cell row and cell column
    );

        for ($y = 1; $y < 8; $y++) {

            for ($i = 1; $i <= 6; $i++) {
                if($dataArray[$y][$i] !== Null) {

                    $newOvercrowding = new Overcrowding2(
                        $dataArray[$y][0],
                        intval(substr($dataArray[0][$i], 0, 4)),
                        $dataArray[$y][$i],
                        $norm
                    );

                    // tell Doctrine you want to (eventually) save the newOvercrowding
                    // (no queries yet)
                    $entityManager->persist($newOvercrowding);
                }

            }
        }

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
    }


    function makeChart() {

        $entityManager = $this->doctrine->getManager();

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $dataArray = $this->Overcrowding2Repository
        ->findByType("Samtliga 16-84 år", 2);

        foreach ($dataArray as $data) {

            $labels[] = $data->getYear();

        }

        $arrayFetch["type"] = ["Samtliga 16-84 år", "Män 16-84 år","Kvinnor 16-84 år","Inrikes född","Utrikes född","Utrikes född utanför Europa","Utrikes född inom Europa"];
        $arrayFetch["lineColor"] = ['#e6194B', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#42d4f4', '#f032e6', '#fabed4', '#469990', '#dcbeff', '#9A6324', '#fffac8', '#800000', '#aaffc3', '#000075', '#a9a9a9', '#000000'];

        $datasets = array();

        for ($i = 0; $i < count($arrayFetch["type"]); $i++) {

            $dataArray = $this->Overcrowding2Repository
            ->findByType($arrayFetch["type"][$i], 2);

            $datasets[$i]["label"] = $arrayFetch["type"][$i];
            $datasets[$i]['backgroundColor'] = $arrayFetch["lineColor"][$i];
            $datasets[$i]['borderColor'] = $arrayFetch["lineColor"][$i];

            foreach ($dataArray as $data) {
                $datasets[$i]['data'][] = $data->getPercentage();
            }


        }

        $chart->setData([
            'labels' => $labels,
            'datasets' => $datasets,
        ],
        );



        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10
                ],
            ],
        ]);

        return $chart;


    }


}
