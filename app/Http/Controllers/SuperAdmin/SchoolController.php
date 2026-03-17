<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Notifications\SchoolAdminCredentialsNotification;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with(['subscriptions' => function ($q) {
            $q->latest();
        }, 'admin'])
            ->withCount(['students', 'teachers', 'campuses'])
            ->get();

        return view('super-admin.schools.index', compact('schools'));
    }

    public function create()
    {
        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('super-admin.schools.create', compact('plans'));
    }

    public function store(Request $request, PaymentService $paymentService)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'campus_count' => ['required', 'integer', 'min:1', 'max:10000'],
            'address' => ['required', 'string', 'max:500'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:8'],
            'tax_id' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'string', 'max:255'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'plan_id' => ['required', 'exists:plans,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $plan = Plan::query()
            ->where('is_active', true)
            ->findOrFail($data['plan_id']);

        $name = trim($data['name']);
        $slug = $this->generateUniqueSlug($name);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('schools/logos', 'public');
        }

        $socialLinks = array_filter([
            'facebook' => $data['facebook'] ?? null,
            'twitter' => $data['twitter'] ?? null,
            'linkedin' => $data['linkedin'] ?? null,
            'instagram' => $data['instagram'] ?? null,
        ], fn ($value) => filled($value));

        $settings = [];
        if ($socialLinks !== []) {
            $settings['social_links'] = $socialLinks;
        }

        $plainPassword = $data['admin_password'];

        DB::transaction(function () use ($data, $name, $slug, $logoPath, $settings, $plan, $paymentService, $plainPassword) {
            $school = School::create([
                'name' => $name,
                'slug' => $slug,
                'campus_count' => $data['campus_count'] ?? null,
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'tax_id' => $data['tax_id'] ?? null,
                'website' => $data['website'] ?? null,
                'logo_path' => $logoPath,
                'settings' => $settings !== [] ? $settings : null,
                'is_active' => (bool) ($data['is_active'] ?? true),
            ]);

            $adminUser = User::create([
                'name' => $data['admin_name'],
                'email' => $data['admin_email'],
                'phone_number' => $data['phone'],
                'password' => Hash::make($plainPassword),
                'school_id' => $school->id,
            ]);

            app(PermissionRegistrar::class)->setPermissionsTeamId($school->id);
            $adminUser->assignRole('School Admin');

            $subscription = Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'status' => 'pending_approval',
                'current_period_start' => null,
                'current_period_end' => null,
            ]);

            $payment = SubscriptionPayment::create([
                'school_id' => $school->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_method' => 'Cash',
                'payment_method_id' => null,
                'transaction_reference' => 'CASH',
                'proof_file_path' => null,
                'status' => 'pending',
            ]);

            $paymentService->approvePayment($payment, 'Cash received by Super Admin at school creation.');

            try {
                $adminUser->notify(new SchoolAdminCredentialsNotification(
                    schoolName: $school->name,
                    email: $adminUser->email,
                    password: $plainPassword,
                    loginUrl: route('login'),
                ));
            } catch (\Exception $e) {
            }
        });

        return redirect()->route('super-admin.schools.index')->with('success', 'School created successfully.');
    }

    public function activate(School $school)
    {
        $school->update(['is_active' => true]);

        return redirect()->back()->with('success', 'School activated successfully.');
    }

    public function deactivate(School $school)
    {
        $school->update(['is_active' => false]);

        return redirect()->back()->with('success', 'School deactivated successfully.');
    }

    private function generateUniqueSlug(string $schoolName): string
    {
        $baseSlug = str($schoolName)->slug()->value();
        $slug = $baseSlug;

        $suffix = 2;
        while (School::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
