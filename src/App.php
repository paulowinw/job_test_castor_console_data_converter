<?php

Namespace Castor;

use Castor\DataWriters\DataWriterFactory;
use Castor\InputDataSources\CsvDataSource;

/*
 * The client class for the app
 */
class App {

    public static function run() : void
    {
        $csvFile = "public/inputs/2.csv"; // Replace with your CSV file path
        $csvDataSource = new CsvDataSource($csvFile);

        $patientWriter = DataWriterFactory::createWriter('patient');
        $patientWriter->writeData($csvDataSource, 'public/outputs/2.csv');

//        $doctors = [
//            // ... your doctor data
//        ];
//
//        $doctorWriter = DataWriterFactory::createWriter('doctor');
//        $doctorWriter->writeData($doctors);

    }

}