<?php

namespace App\Services;

class SchoolContext
{
    protected static $schoolId;

    public static function setSchoolId($id)
    {
        self::$schoolId = $id;
    }

    public static function getSchoolId()
    {
        return self::$schoolId;
    }

    public static function check()
    {
        return !is_null(self::$schoolId);
    }
}
