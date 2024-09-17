<?php

namespace Castor\DataWriters;

use Castor\InputDataSources\DataSourceInterface;
use DataWriterInterface;

class DoctorWriter implements DataWriterInterface
{
    public function writeData(DataSourceInterface $data, string $filename)
    {
        // Implement doctor data writing logic here
        // For example, using a different CSV format or database query
    }
}
