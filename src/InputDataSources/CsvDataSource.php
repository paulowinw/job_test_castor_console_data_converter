<?php

namespace Castor\InputDataSources;

class CsvDataSource implements DataSourceInterface
{

    public function __construct(private readonly string $filename)
    {
    }

    public function readData(): array
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