<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\SchoolAdminCredentialsNotification;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SuperAdminCreatesSchoolAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_super_admin_can_create_school_admin_and_credentials_email_is_sent()
    {
        Notification::fake();

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $response = $this->actingAs($superAdmin)->post(route('super-admin.admin-users.store'), [
            'school_name' => 'New School',
            'admin_name' => 'New Admin',
            'email' => 'admin@newschool.test',
            'phone_number' => '555-1000',
            'password' => 'password123',
            'campus_count' => 2,
            'address' => 'School Address',
        ]);

        $response->assertRedirect(route('super-admin.admin-users.index'));

        $adminUser = User::where('email', 'admin@newschool.test')->firstOrFail();
        $this->assertNotNull($adminUser->school_id);

        Notification::assertSentTo(
            $adminUser,
            SchoolAdminCredentialsNotification::class
        );
    }
}
