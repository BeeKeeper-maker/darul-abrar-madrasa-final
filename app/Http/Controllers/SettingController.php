<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the specified settings in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'academic_session' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update text-based settings
        foreach ($validatedData as $key => $value) {
            if ($key === 'app_logo') continue; // Skip file upload for now

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Handle file upload for app_logo
        if ($request->hasFile('app_logo')) {
            // Get old logo path
            $oldLogo = Setting::where('key', 'app_logo')->first();

            // Store new logo
            $path = $request->file('app_logo')->store('logos', 'public');

            // Update database
            Setting::updateOrCreate(
                ['key' => 'app_logo'],
                ['value' => $path]
            );

            // Delete old logo if it exists
            if ($oldLogo && $oldLogo->value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldLogo->value);
            }
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
