<?php

namespace Castor\DataWriters;

use Castor\InputDataSources\DataSourceInterface;
use DataWriterInterface;

class PatientWriter implements DataWriterInterface
{
    private array $columns = [
        'Patient ID' => 'record_id',
        'Name' => 'name',
        'Gender' => 'gender',
        'Length' => 'height_cm',
        'Weight' => 'weight_kg',
        'Pregnant' => 'pregnant',
        'Months Pregnant' => 'pregnancy_duration_weeks',
        'Date of diagnosis' => 'date_diagnosis',
    ];
    private array $columnsValueObjectsClasses = [
        'Gender' => 'Gender',
        'Length' => 'Length',
        'Pregnant' => 'Pregnant',
        'Months Pregnant' => 'MonthsPregnant',
        'Date of diagnosis' => 'DateDiagnosis',
    ];
    public function writeData(DataSourceInterface $dataSource, string $filename) : void
    {
        $fp = fopen($filename, 'w');

        // Write the header row
        fputcsv($fp, array_values($this->columns));

        // Write the data rows
        foreach ($dataSource->readData() as $patient) {
            $transformedData = [];
            foreach ($this->columns as $columnName => $targetColumnName) {
                $value = $patient[$columnName];
                $strategy = new $this->columnsValueObjectsClasses[$columnName]($value) ?? null;
                if ($strategy) {
                    $value = $strategy->transform($value);
                }
                $transformedData[$targetColumnName] = $value;
            }
            fputcsv($fp, array_values($transformedData));
        }
        fclose($fp);
    }
}