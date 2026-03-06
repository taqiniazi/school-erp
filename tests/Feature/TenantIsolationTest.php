<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use App\Services\SchoolContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_schools_are_isolated(): void
    {
        $schoolA = School::create(['name' => 'School A', 'slug' => 'school-a']);
        SchoolContext::setSchoolId($schoolA->id);
        User::create([
            'name' => 'User A',
            'email' => 'user-a@example.com',
            'password' => bcrypt('password'),
        ]);

        $schoolB = School::create(['name' => 'School B', 'slug' => 'school-b']);
        SchoolContext::setSchoolId($schoolB->id);
        User::create([
            'name' => 'User B',
            'email' => 'user-b@example.com',
            'password' => bcrypt('password'),
        ]);

        SchoolContext::setSchoolId($schoolA->id);
        $this->assertSame(1, User::count());
        $this->assertSame('user-a@example.com', User::first()->email);

        SchoolContext::setSchoolId($schoolB->id);
        $this->assertSame(1, User::count());
        $this->assertSame('user-b@example.com', User::first()->email);

        SchoolContext::setSchoolId(null);
        $this->assertSame(2, User::count());
    }
}
