<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $telegramUsers = \App\Models\TelegramUser::all();
        return view('admin.settings', compact('settings', 'telegramUsers'));
    }

    public function store(Request $request)
    {
        $keys = ['telegram_receiver_name', 'telegram_bot_token', 'telegram_chat_id'];
        
        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()->back()->with('success', 'Konfigurasi berhasil disimpan!');
    }
}
