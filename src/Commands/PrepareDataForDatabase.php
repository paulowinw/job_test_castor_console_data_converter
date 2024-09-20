<?php

namespace Castor\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Castor\DataWriters\DataWriterFactory;
use Castor\InputDataSources\CsvDataSource;

class PrepareDataForDatabase extends Command
{
    protected static $defaultName = 'prepare:data';

    private const OUTPUT_DIR = 'public/outputs/';
    private const DEFAULT_FILE = "public/inputs/3.csv";

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
            if (empty($csvFile)) {
                $csvFile = self::DEFAULT_FILE;
            }
        }

        $filename = basename($csvFile);
        $csvDataSource = new CsvDataSource($csvFile);

        $transformationConfig = [];
        $newColumnNames = [];
        foreach ($csvDataSource->readData() as $key => $values) {
            $this->printArrayAsTable($key, $values);
            $targetColumn = $this->getTargetColumnNameByConsoleInteraction();
            $transformation = $this->getTransformationByConsoleInteraction();

            if (empty($targetColumn)) {
                $transformationConfig[$key] = $transformation;
            } else {
                $newColumnNames[$key] = $targetColumn;
                $transformationConfig[$targetColumn] = $transformation;
            }
        }

        if (!empty($newColumnNames)) {
            $csvDataSource->configNewColumnNames($newColumnNames);
        }

        $patientWriter = DataWriterFactory::createWriter('patient');
        $patientWriter->writeData($csvDataSource, self::OUTPUT_DIR . $filename, $transformationConfig);

        return Command::SUCCESS;
    }



    public function printArrayAsTable(string $header, array $values): void
    {
        // Count the elements in the  array key
        $count = strlen($header);

        // Print the separator row
        print("Current Column:\n\n");
        print("$header\n");
        print(str_repeat("-", $count) . "\n");

        // Print the data rows
        foreach ($values as $value) {
            print("$value\n");
        }
        print("\n");
    }

    public function getCSVPathByConsoleInteraction()
    {
        // Prompt the user for the target column name
        echo "Enter the Path for the CSV File: (default: public/inputs/3.csv)\n";
        $csvPath = readline();
        echo "\n";

        // Return the target column name
        return $csvPath;
    }

    public function getTargetColumnNameByConsoleInteraction()
    {
        // Prompt the user for the target column name
        echo "Enter the target column name:\n";
        $targetColumnName = readline();
        echo "\n";

        // Return the target column name
        return $targetColumnName;
    }

    public function getTransformationByConsoleInteraction()
    {
        // Prompt the user for the transformation

        echo "Enter the transformation to be applied to the column, options:\n";
        echo "1. ".CsvDataSource::CONVERSION_OPTION_1."\n";
        echo "2. ".CsvDataSource::CONVERSION_OPTION_2."\n";
        echo "3. ".CsvDataSource::CONVERSION_OPTION_3."\n";
        echo "4. ".CsvDataSource::CONVERSION_OPTION_4."\n";
        echo "5. ".CsvDataSource::CONVERSION_OPTION_5."\n";
        echo "6. ".CsvDataSource::CONVERSION_OPTION_NULL."\n\n";
        echo "Enter the number of the transformation that you want:\n";
        $transformation = readline();
        echo "\n";

        // Return the transformation
        return ($transformation == 6) ? null : $transformation;
    }

}