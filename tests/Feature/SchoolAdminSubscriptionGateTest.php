<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SchoolAdminSubscriptionGateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_school_admin_without_subscription_is_redirected_to_choose_plan()
    {
        $school = School::create([
            'name' => 'Test School',
            'slug' => 'test-school',
            'address' => 'Address',
            'phone' => '123',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);

        app(PermissionRegistrar::class)->setPermissionsTeamId($school->id);
        $user->assignRole('School Admin');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertRedirect(route('billing.choose-plan'));
    }

    public function test_school_admin_with_subscription_can_access_admin_dashboard()
    {
        $plan = Plan::create([
            'name' => 'Basic',
            'code' => 'basic',
            'price' => 10,
            'billing_cycle' => 'monthly',
            'features' => [],
            'is_active' => true,
        ]);

        $school = School::create([
            'name' => 'Test School 2',
            'slug' => 'test-school-2',
            'address' => 'Address',
            'phone' => '123',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'school_id' => $school->id,
        ]);

        app(PermissionRegistrar::class)->setPermissionsTeamId($school->id);
        $user->assignRole('School Admin');

        Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'current_period_start' => now()->subDay(),
            'current_period_end' => now()->addMonth(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Admin Dashboard');
    }
}
