<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit');
    }

    public function update(SettingRequest $request, ImageUploadService $images)
    {
        $validated = $request->validated();

        foreach (['logo', 'favicon'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $validated[$imageKey] = $images->replace(Setting::getValue($imageKey), $request->file($imageKey), 'settings');
            } else {
                unset($validated[$imageKey]);
            }
        }

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
