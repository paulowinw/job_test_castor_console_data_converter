<?php

namespace InputDataSources;

use PHPUnit\Framework\TestCase;
use Castor\InputDataSources\CsvDataSource;

class CsvDataSourceTest extends TestCase
{
    public function testReadData()
    {
        $dataSource = new CsvDataSource('public/inputs/4.csv');
        $data = $dataSource->readData();

        // Assert that the data is an array
        $this->assertIsArray($data);

        // Assert that the data contains the expected header and values
        $expectedHeader = ['Patient ID', 'Name', 'Gender', 'Length', 'Weight', 'Pregnant', 'Months Pregnant', 'Date of diagnosis'];
        $this->assertEquals($expectedHeader, array_keys($data));

        $expectedValues = [
            ['Patient ID' => '1', 'Name' => 'Johnson', 'Gender' => 'Female', 'Length' => '1.69', 'Weight' => '64', 'Pregnant' => 'Yes', 'Months Pregnant' => '8', 'Date of diagnosis' => '21-07-2016'],
            ['Patient ID' => '2', 'Name' => 'Smith', 'Gender' => 'Male', 'Length' => '1.69', 'Weight' => '89', 'Pregnant' => 'No', 'Months Pregnant' => '', 'Date of diagnosis' => '04-02-2015'],
            ['Patient ID' => '3', 'Name' => 'Lewis', 'Gender' => 'Female', 'Length' => '1.55', 'Weight' => '54', 'Pregnant' => 'No', 'Months Pregnant' => '', 'Date of diagnosis' => '21-12-2016'],
        ];
        $this->assertEquals($expectedValues, array_values($data));
    }

    public function testGetDataOrderedByLine()
    {
        $dataSource = new CsvDataSource('public/inputs/1.csv');
        $dataSource->readData(); // Ensure data is read first
        $data = $dataSource->getDataOrderedByLine();

        // Assert that the data is an array
        $this->assertIsArray($data);

        // Assert that the data is ordered by line and contains the expected values
        $expectedData = [
            ['1', 'Johnson', 'Female', '1.69', '64', 'Yes', '8', '21-07-2016'],
            ['2', 'Smith', 'Male', '1.69', '89', 'No', '', '04-02-2015'],
            ['3', 'Lewis', 'Female', '1.55', '54', 'No', '', '21-12-2016'],
        ];
        $this->assertEquals($expectedData, $data);
    }


}