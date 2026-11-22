<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('office.settings', [
            'settings' => Setting::values(),
            'resources' => Resource::orderBy('position')->get(),
            'staff' => User::whereIn('role', ['counselor', 'admin'])->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'office_name' => ['required', 'string', 'max:120'],
            'office_location' => ['nullable', 'string', 'max:200'],
            'office_hours' => ['nullable', 'string', 'max:200'],
            'office_phone' => ['nullable', 'string', 'max:60'],
            'office_email' => ['nullable', 'email', 'max:190'],
            'phq9_threshold' => ['required', 'integer', 'between:1,27'],
            'gad7_threshold' => ['required', 'integer', 'between:1,21'],
            'resources' => ['array'],
            'resources.*.title' => ['nullable', 'string', 'max:120'],
            'resources.*.body' => ['nullable', 'string', 'max:1000'],
        ]);

        Setting::put(collect($data)->except('resources')->map(fn ($v) => (string) $v)->all());

        Resource::query()->delete();
        collect($data['resources'] ?? [])
            ->filter(fn ($r) => filled($r['title'] ?? null) && filled($r['body'] ?? null))
            ->values()
            ->each(fn ($r, $i) => Resource::create(['title' => $r['title'], 'body' => $r['body'], 'position' => $i]));

        return back()->with('status', 'Settings saved.');
    }

    public function addStaff(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', Rule::in(['counselor', 'admin'])],
            'password' => ['required', Password::min(8)],
        ]);

        User::create($data);

        return back()->with('status', $data['name'].' can now sign in as '.$data['role'].'.');
    }
}
