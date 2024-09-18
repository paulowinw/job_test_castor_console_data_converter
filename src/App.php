<?php

Namespace Castor;

use Symfony\Component\Console\Application;
use Castor\Commands\PrepareDataForDatabase;

/*
 * The client class for the app
 */
class App {

    public static function run() : void
    {
        $application = new Application();
        $application->add(new PrepareDataForDatabase());

        $application->run();


//        $output = exec("php app/console prepare:data");
//        echo $output;


//        $csvFile = "public/inputs/3.csv"; // Replace with your CSV file path
//        $csvDataSource = new CsvDataSource($csvFile);
//
//        $patientWriter = DataWriterFactory::createWriter('patient');
//        $patientWriter->writeData($csvDataSource, 'public/outputs/3.csv');

//        $doctors = [
//            // ... your doctor data
//        ];
//
//        $doctorWriter = DataWriterFactory::createWriter('doctor');
//        $doctorWriter->writeData($doctors);

    }

}