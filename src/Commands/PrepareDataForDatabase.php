<?php

namespace Castor\Commands;

use Castor\DataWriters\DataWriterFactory;
use Castor\InputDataSources\CsvDataSource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareDataForDatabase extends Command
{
    protected static $defaultName = 'prepare:data';

    private const OUTPUT_DIR = 'public/outputs/';

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Prepares data for database')
            ->addArgument('csvFile', InputArgument::OPTIONAL, 'Path to the CSV file (default: public/inputs/3.csv)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csvFile = $input->getArgument('csvFile');

        if (empty($csvFile)) {
            $csvFile = $this->getCSVPathByConsoleInteraction();

            $csvFile = "public/inputs/3.csv";
        }

        $filename = basename($csvFile);
        $csvDataSource = new CsvDataSource($csvFile);

        foreach ($csvDataSource->readData() as $patient) {

        }

        $patientWriter = DataWriterFactory::createWriter('patient');
        $patientWriter->writeData($csvDataSource, self::OUTPUT_DIR . $filename);

        // Encapsulate console interactions in a separate class
//        $consoleInteractions = new ConsoleInteractions();
//        $consoleInteractions->getTargetColumnName();
//        $consoleInteractions->getTransformation();

        return Command::SUCCESS;
    }

    public function getCSVPathByConsoleInteraction()
    {
        // Prompt the user for the target column name
        echo "Enter the Path for the CSV File: (default: public/inputs/3.csv)\n";
        $csvPath = readline();

        // Return the target column name
        return $csvPath;
    }

    public function getTargetColumnNameByConsoleInteraction()
    {
        // Prompt the user for the target column name
        echo "Enter the target column name:\n";
        $targetColumnName = readline();

        // Return the target column name
        return $targetColumnName;
    }

    public function getTransformationByConsoleInteraction()
    {
        // Prompt the user for the transformation
        echo "
            Enter the transformation (e.g., uppercase, lowercase, reverse): \n
            1. Female or male to number \n
            2. Height to cms \n
            3. Remove dots from number \n
            4. Yes or no to number \n
            5. Convert months to weeks \n
            6. Date to database format \n
        ";
        $transformation = readline();

        // Return the transformation
        return $transformation;
    }

}