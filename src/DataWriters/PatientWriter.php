<?php

namespace Castor\DataWriters;

use Castor\InputDataSources\DataSourceInterface;
use Castor\FieldValueObjects\Gender;
use Castor\FieldValueObjects\Length;
use Castor\FieldValueObjects\Pregnant;
use Castor\FieldValueObjects\MonthsPregnant;
use Castor\FieldValueObjects\DateDiagnosis;

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
    private array $valueObjectsClasses = [
        'Gender' => Gender::class,
        'Length' => Length::class,
        'Pregnant' => Pregnant::class,
        'Months Pregnant' => MonthsPregnant::class,
        'Date of diagnosis' => DateDiagnosis::class,
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
                if (isset($patient[$columnName])) {
                    $value = $patient[$columnName];
                    if (isset($this->valueObjectsClasses[$columnName])) {
                        $strategy = new $this->valueObjectsClasses[$columnName]($value) ?? null;
                        $transformedData[$targetColumnName] = $strategy->transform($value);
                    } else {
                        $transformedData[$targetColumnName] = $value;
                    }
                } else {
                    $transformedData[$targetColumnName] = '';
                }
            }
            fputcsv($fp, array_values($transformedData));
        }
        fclose($fp);
    }
}