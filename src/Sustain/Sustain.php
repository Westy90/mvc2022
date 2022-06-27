<?php

namespace App\Sustain;

use App\Sustain\Sustain;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Overcrowding2;
use App\Repository\Overcrowding2Repository;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

class Sustain
{


    protected ManagerRegistry $doctrine;
    protected Overcrowding2Repository $Overcrowding2Repository;

    /**
    * DiffManager constructor.
    * @param ManagerRegistry $doctrine
    * @param Overcrowding2Repository $Overcrowding2Repository
    */
    public function __construct(ManagerRegistry $doctrine, Overcrowding2Repository $Overcrowding2Repository)
    {
        $this->doctrine = $doctrine;
        $this->Overcrowding2Repository = $Overcrowding2Repository;
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
}
