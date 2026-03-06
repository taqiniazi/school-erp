<?php

namespace Tests;

use App\Services\SchoolContext;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        SchoolContext::setSchoolId(null);
        app(PermissionRegistrar::class)->setPermissionsTeamId(null);
    }
}
