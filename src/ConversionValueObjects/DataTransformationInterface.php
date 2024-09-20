<?php

namespace Castor\ConversionValueObjects;

/*
 * Strategy Design Pattern
 *
 * To treat each value depending on its type
 *
 * They are defined as value objects, it's an well known programming concept
 */
interface DataTransformationInterface
{
    public function transform();
    public function getValue();
}