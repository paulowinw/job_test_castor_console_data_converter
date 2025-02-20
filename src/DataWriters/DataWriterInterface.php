<?php

namespace Castor\DataWriters;

use Castor\InputDataSources\DataSourceInterface;

/*
 * Factory Design Pattern
 *
 * To have the possibility of write the data depending on the output needed
 */
interface DataWriterInterface
{
    public function writeData(DataSourceInterface $dataSource, string $filename) : void;
}