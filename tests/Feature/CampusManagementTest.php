<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\School;
use App\Models\Campus;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CampusManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles if not exist
        if (!Role::where('name', 'School Admin')->exists()) {
            Role::create(['name' => 'School Admin', 'guard_name' => 'web']);
        }
    }

    public function test_school_admin_can_create_campus()
    {
        // Setup School and Admin
        $school = School::factory()->create();
        $admin = User::factory()->create([
            'school_id' => $school->id,
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('School Admin');

        // Create a subscription for the school to bypass the gate
        $plan = Plan::create([
            'name' => 'Basic Plan',
            'code' => 'basic',
            'price' => 100,
            'billing_cycle' => 'monthly',
            'features' => json_encode(['students' => 100]),
        ]);
        Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('campuses.store'), [
            'name' => 'North Campus',
            'address' => '123 North St',
            'phone' => '555-0101',
            'email' => 'north@example.com',
            'is_main' => true,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('campuses.index'));
        $this->assertDatabaseHas('campuses', [
            'name' => 'North Campus',
            'school_id' => $school->id,
            'is_main' => 1,
        ]);
    }

    public function test_campuses_are_isolated_by_school()
    {
        $this->withoutExceptionHandling();
        
        // Setup School 1
        $school1 = School::factory()->create();
        $admin1 = User::factory()->create(['school_id' => $school1->id]);
        $admin1->assignRole('School Admin');
        
        // Setup School 2
        $school2 = School::factory()->create();
        $admin2 = User::factory()->create(['school_id' => $school2->id]);
        $admin2->assignRole('School Admin');

        // Create subscription for School 1 (to access dashboard)
        $plan = Plan::create(['name' => 'Plan', 'code' => 'plan', 'price' => 10, 'billing_cycle' => 'monthly']);
        Subscription::create(['school_id' => $school1->id, 'plan_id' => $plan->id, 'starts_at' => now(), 'ends_at' => now()->addDays(30), 'status' => 'active']);

        // Create Campus for School 2
        $campus2 = Campus::create([
            'school_id' => $school2->id,
            'name' => 'School 2 Campus',
            'address' => 'Address',
            'is_main' => true,
            'is_active' => true,
        ]);

        // Admin 1 should not see School 2's campus
        $response = $this->actingAs($admin1)->get(route('campuses.index'));
        $response->assertStatus(200);
        $response->assertDontSee('School 2 Campus');
    }
}
