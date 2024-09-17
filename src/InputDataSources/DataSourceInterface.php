<?php

namespace Castor\InputDataSources;

/*
 * Strategy Design Pattern
 *
 * To have the possibility of loading the data depending on the format
 */
interface DataSourceInterface {
    public function readData(): array;
}