<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        $settings = [
            'app_name' => Setting::get('app_name', config('app.name')),
            'app_logo' => Setting::get('app_logo'),
            'export_logo' => Setting::get('export_logo'),
            'app_favicon' => Setting::get('app_favicon'),
            'signature_om' => Setting::get('signature_om'),
            'signature_gm' => Setting::get('signature_gm'),
            'signature_proc' => Setting::get('signature_proc'),
        ];
        
        return view('settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|max:2048',
            'export_logo' => 'nullable|image|max:2048',
            'app_favicon' => 'nullable|image|max:1024',
            'signature_om' => 'nullable|image|max:1024',
            'signature_gm' => 'nullable|image|max:1024',
            'signature_proc' => 'nullable|image|max:1024',
        ]);

        Setting::set('app_name', $request->app_name);

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $path);
        }

        if ($request->hasFile('export_logo')) {
            $path = $request->file('export_logo')->store('settings', 'public');
            Setting::set('export_logo', $path);
        }

        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            Setting::set('app_favicon', $path);
        }

        if ($request->hasFile('signature_om')) {
            $path = $request->file('signature_om')->store('settings', 'public');
            Setting::set('signature_om', $path);
        }

        if ($request->hasFile('signature_gm')) {
            $path = $request->file('signature_gm')->store('settings', 'public');
            Setting::set('signature_gm', $path);
        }

        if ($request->hasFile('signature_proc')) {
            $path = $request->file('signature_proc')->store('settings', 'public');
            Setting::set('signature_proc', $path);
        }

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }
}
