<?php

namespace Castor\DataWriters;

class DataWriterFactory
{
    public static function createWriter(string $type)
    {
        switch ($type) {
            case 'patient':
                return new PatientWriter();
            case 'doctor':
                return new DoctorWriter();
            default:
                throw new Exception("Invalid writer type");
        }
    }
}