<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\SchoolContext;

class RoleBasedRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles and permissions
        $this->seed(RolesAndPermissionsSeeder::class);
        // Ensure no tenant context bleeds between tests
        SchoolContext::setSchoolId(null);
    }

    public function test_admin_redirects_to_admin_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Default password in UserFactory
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_teacher_redirects_to_teacher_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Teacher');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('teacher.dashboard'));
    }

    public function test_student_redirects_to_student_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Student');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('student.dashboard'));
    }

    public function test_parent_redirects_to_parent_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Parent');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('parent.dashboard'));
    }

    public function test_user_without_specific_role_redirects_to_default_dashboard()
    {
        // Create a role that is not handled specifically, or just no role if allowed
        // But our logic handles specific roles. If no role matches, it goes to HOME.
        $user = User::factory()->create();
        // No role assigned

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard'); // RouteServiceProvider::HOME
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    public function test_teacher_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('Teacher');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }
}
