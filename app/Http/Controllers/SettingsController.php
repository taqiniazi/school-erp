<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function general(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $settings = is_array($school->settings) ? $school->settings : [];
        $general = isset($settings['general']) && is_array($settings['general']) ? $settings['general'] : [];

        return view('settings.general', [
            'school' => $school,
            'general' => $general,
        ]);
    }

    public function updateGeneral(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'currency' => ['nullable', 'string', 'max:10'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $school->fill([
            'name' => $data['name'],
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'tax_id' => $data['tax_id'] ?? null,
            'website' => $data['website'] ?? null,
        ]);

        if ($request->hasFile('logo')) {
            if ($school->logo_path) {
                Storage::disk('public')->delete($school->logo_path);
            }
            $school->logo_path = $request->file('logo')->store('schools', 'public');
        }

        $settings = is_array($school->settings) ? $school->settings : [];
        $general = isset($settings['general']) && is_array($settings['general']) ? $settings['general'] : [];
        $general = array_merge($general, [
            'timezone' => $data['timezone'] ?? null,
            'currency' => $data['currency'] ?? null,
        ]);
        $settings['general'] = $general;
        $school->settings = $settings;

        $school->save();

        return redirect()->route('settings.general')->with('success', 'General settings saved.');
    }

    public function email(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $settings = is_array($school->settings) ? $school->settings : [];
        $email = isset($settings['email']) && is_array($settings['email']) ? $settings['email'] : [];

        return view('settings.email', [
            'school' => $school,
            'emailSettings' => $email,
        ]);
    }

    public function updateEmail(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $data = $request->validate([
            'mailer' => ['required', Rule::in(['smtp', 'log', 'sendmail'])],
            'host' => ['nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'encryption' => ['nullable', Rule::in(['tls', 'ssl'])],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'from_address' => ['nullable', 'email', 'max:255'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $settings = is_array($school->settings) ? $school->settings : [];
        $email = isset($settings['email']) && is_array($settings['email']) ? $settings['email'] : [];

        $email['mailer'] = $data['mailer'];
        $email['host'] = $data['host'] ?? null;
        $email['port'] = $data['port'] ?? null;
        $email['encryption'] = $data['encryption'] ?? null;
        $email['username'] = $data['username'] ?? null;
        if (! empty($data['password'])) {
            $email['password'] = Crypt::encryptString($data['password']);
        }
        $email['from_address'] = $data['from_address'] ?? null;
        $email['from_name'] = $data['from_name'] ?? null;

        $settings['email'] = $email;
        $school->settings = $settings;
        $school->save();

        return redirect()->route('settings.email')->with('success', 'Email settings saved.');
    }

    public function sendTestEmail(Request $request)
    {
        $data = $request->validate([
            'to_email' => ['required', 'email', 'max:255'],
        ]);

        $school = $request->user()->school;
        abort_unless($school, 403);

        $settings = is_array($school->settings) ? $school->settings : [];
        $email = isset($settings['email']) && is_array($settings['email']) ? $settings['email'] : [];

        $mailer = $email['mailer'] ?? config('mail.default');
        $password = null;
        if (! empty($email['password'])) {
            try {
                $password = Crypt::decryptString($email['password']);
            } catch (\Throwable $e) {
                $password = null;
            }
        }

        config([
            'mail.default' => $mailer,
            'mail.mailers.smtp.host' => $email['host'] ?? config('mail.mailers.smtp.host'),
            'mail.mailers.smtp.port' => $email['port'] ?? config('mail.mailers.smtp.port'),
            'mail.mailers.smtp.encryption' => $email['encryption'] ?? config('mail.mailers.smtp.encryption'),
            'mail.mailers.smtp.username' => $email['username'] ?? config('mail.mailers.smtp.username'),
            'mail.mailers.smtp.password' => $password ?? config('mail.mailers.smtp.password'),
            'mail.from.address' => $email['from_address'] ?? config('mail.from.address'),
            'mail.from.name' => $email['from_name'] ?? config('mail.from.name'),
        ]);

        try {
            Mail::raw('This is a test email from School ERP.', function ($message) use ($data) {
                $message->to($data['to_email'])->subject('Test Email');
            });
        } catch (\Throwable $e) {
            return redirect()->route('settings.email')->with('error', 'Failed to send test email: '.$e->getMessage());
        }

        return redirect()->route('settings.email')->with('success', 'Test email sent.');
    }

    public function backup(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $dir = $this->backupDir((int) $school->id);
        $files = Storage::disk('local')->files($dir);

        $backups = collect($files)
            ->filter(fn ($path) => str_ends_with($path, '.json'))
            ->map(function ($path) {
                return [
                    'file' => basename($path),
                    'size' => Storage::disk('local')->size($path),
                    'last_modified' => Storage::disk('local')->lastModified($path),
                ];
            })
            ->sortByDesc('last_modified')
            ->values()
            ->all();

        return view('settings.backup', [
            'school' => $school,
            'backups' => $backups,
        ]);
    }

    public function createBackup(Request $request)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $payload = [
            'type' => 'school_backup',
            'created_at' => now()->toIso8601String(),
            'school' => [
                'id' => $school->id,
                'name' => $school->name,
                'slug' => $school->slug,
                'address' => $school->address,
                'phone' => $school->phone,
                'email' => $school->email,
                'tax_id' => $school->tax_id,
                'website' => $school->website,
                'logo_path' => $school->logo_path,
                'is_active' => (bool) $school->is_active,
            ],
            'settings' => is_array($school->settings) ? $school->settings : [],
        ];

        $dir = $this->backupDir((int) $school->id);
        $fileName = 'backup_'.$school->id.'_'.now()->format('Ymd_His').'.json';

        Storage::disk('local')->put($dir.'/'.$fileName, json_encode($payload, JSON_PRETTY_PRINT));

        return redirect()->route('settings.backup')->with('success', 'Backup created.');
    }

    public function downloadBackup(Request $request, string $backupFile)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $backupFile = $this->sanitizeBackupFile($backupFile);
        if ($backupFile === null) {
            abort(404);
        }

        $path = $this->backupDir((int) $school->id).'/'.$backupFile;
        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }

    public function deleteBackup(Request $request, string $backupFile)
    {
        $school = $request->user()->school;
        abort_unless($school, 403);

        $backupFile = $this->sanitizeBackupFile($backupFile);
        if ($backupFile === null) {
            abort(404);
        }

        $path = $this->backupDir((int) $school->id).'/'.$backupFile;
        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        return redirect()->route('settings.backup')->with('success', 'Backup deleted.');
    }

    private function backupDir(int $schoolId): string
    {
        return 'backups/schools/'.$schoolId;
    }

    private function sanitizeBackupFile(string $backupFile): ?string
    {
        $backupFile = basename($backupFile);
        if (! preg_match('/^backup_\d+_\d{8}_\d{6}\.json$/', $backupFile)) {
            return null;
        }

        return $backupFile;
    }
}
