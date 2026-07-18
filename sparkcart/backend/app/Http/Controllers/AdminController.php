<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function settings()
    {
        $settings = [
            'store_name' => Setting::getValue('store_name', 'SparkCart Shop'),
            'store_tagline' => Setting::getValue('store_tagline', 'Quality solar shop products'),
            'support_email' => Setting::getValue('support_email', 'support@example.com'),
            'support_phone' => Setting::getValue('support_phone', '+254700000000'),
            'mpesa_paybill' => Setting::getValue('mpesa_paybill', config('mpesa.shortcode')),
            'mpesa_short_code' => Setting::getValue('mpesa_short_code', config('mpesa.shortcode')),
            'mpesa_callback_url' => Setting::getValue('mpesa_callback_url', config('mpesa.callbacks.callback_url')),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_tagline' => 'nullable|string|max:255',
            'support_email' => 'nullable|email|max:255',
            'support_phone' => 'nullable|string|max:32',
            'mpesa_paybill' => 'nullable|string|max:64',
            'mpesa_short_code' => 'nullable|string|max:64',
            'mpesa_callback_url' => 'nullable|url|max:255',
        ]);

        foreach ($request->only([
            'store_name',
            'store_tagline',
            'support_email',
            'support_phone',
            'mpesa_paybill',
            'mpesa_short_code',
            'mpesa_callback_url',
        ]) as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('status', 'Store settings updated successfully.');
    }
}
