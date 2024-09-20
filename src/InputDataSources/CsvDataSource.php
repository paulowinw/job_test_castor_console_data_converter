<?php

namespace Castor\InputDataSources;

use Castor\ConversionValueObjects\ConvertMonthsToWeeks;
use Castor\ConversionValueObjects\DateToDatabaseFormat;
use Castor\ConversionValueObjects\FemaleMaleToNumber;
use Castor\ConversionValueObjects\RemoveDotsFromNumber;
use Castor\ConversionValueObjects\YesNoToNumber;

class CsvDataSource implements DataSourceInterface
{
    private array $data;

    public const CONVERSION_OPTION_1 = 'Female or male to number';
    public const CONVERSION_OPTION_2 = 'Remove dots from number';
    public const CONVERSION_OPTION_3 = 'Yes or no to number';
    public const CONVERSION_OPTION_4 = 'Convert months to weeks';
    public const CONVERSION_OPTION_5 = 'Date to database format';
    public const CONVERSION_OPTION_NULL = 'N/A';

    private array $optionsByNumber = [
         1 => self::CONVERSION_OPTION_1 ,
         2 => self::CONVERSION_OPTION_2 ,
         3 => self::CONVERSION_OPTION_3 ,
         4 => self::CONVERSION_OPTION_4 ,
         5 => self::CONVERSION_OPTION_5
    ];

    private array $conversionObjectClasses = [
        self::CONVERSION_OPTION_1 => FemaleMaleToNumber::class,
        self::CONVERSION_OPTION_2 => RemoveDotsFromNumber::class,
        self::CONVERSION_OPTION_3 => YesNoToNumber::class,
        self::CONVERSION_OPTION_4 => ConvertMonthsToWeeks::class,
        self::CONVERSION_OPTION_5 => DateToDatabaseFormat::class
    ];

    public function __construct(private readonly string $filename)
    {
    }

    public function readData(): array
    {
        $data = [];
        $header = null;
        $columnData = [];

        if (($handle = fopen($this->filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!$header) {
                    $header = explode(';', $row[0]);
                } else {
                    $row = explode(';', $row[0]);
                    $rowFormatted = [];
                    foreach ($row as $key => $value) {
                        $rowFormatted[$header[$key]] = $value;
                        $columnData[$header[$key]][] = $value;
                    }
                    $data[] = $rowFormatted;
                }
            }
            fclose($handle);
        }

        $this->data = $columnData;
        // Return the array with column names and their values
        return $columnData;
    }

    public function configNewColumnNames(array $columnNames): array
    {
        $newData = [];
        foreach ($columnNames as $key => $value) {
            $newData[$value] = $this->data[$key];
            unset($this->data[$key]);
        }
        $this->data = array_merge($this->data, $newData);
        return $newData;
    }

    public function transformData(array $config): array
    {
        $dataTransformed = [];
        foreach ($config as $targetColumn => $transformation) {
            $valuesTransformed = [];
            if (!empty($transformation) && $transformation !== self::CONVERSION_OPTION_NULL) {
                foreach ($this->data[$targetColumn] as $value) {
                    $conversion = new $this->conversionObjectClasses[$this->optionsByNumber[$transformation]]($value);
                    $valuesTransformed[] = $conversion->transform();
                }
                $dataTransformed[$targetColumn] = $valuesTransformed;
            } else {
                $dataTransformed[$targetColumn] = $this->data[$targetColumn];
            }
        }

        $this->data = $dataTransformed;
        return $dataTransformed;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function getDataOrderedByLine() : array
    {
        $data = $this->data;

        // Get the first array key (e.g., 'patient')
        $firstKey = array_keys($data)[0];

        // Create a new array with the desired format
        $result = [];
        foreach ($data[$firstKey] as $index => $value) {
            $row = [];
            foreach ($data as $values) {
                $row[] = $values[$index];
            }
            $result[] = $row;
        }

        return $result;
    }


    public function readGetDataOrderedByLine(): array
    {
        $data = [];
        $header = null;

        if (($handle = fopen($this->filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!$header) {
                    $header = explode(';', $row[0]);
                } else {
                    $row = explode(';', $row[0]);
                    $rowFormatted = [];
                    foreach ($row as $key => $value ){
                        $rowFormatted[$header[$key]] = $value;
                    }
                    $data[] = $rowFormatted;
                }
            }
            fclose($handle);
        }
        return $data;

    }
}