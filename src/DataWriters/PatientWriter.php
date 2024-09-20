<?php

namespace Castor\DataWriters;

use Castor\InputDataSources\DataSourceInterface;

class PatientWriter implements DataWriterInterface
{
    public function writeData(DataSourceInterface $dataSource, string $filename, array $transformationConfig = null) : void
    {
        $fp = fopen($filename, 'w');

        $dataSource->transformData($transformationConfig);
        $data = $dataSource->getDataOrderedByLine();
        // Write the header row
        fputcsv($fp, array_keys($dataSource->getData()));

        // Write the data rows
        foreach ($data as $patient) {
            fputcsv($fp, array_values($patient));
        }
        fclose($fp);
    }
}