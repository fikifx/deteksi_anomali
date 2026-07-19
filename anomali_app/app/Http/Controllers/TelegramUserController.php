<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;

class TelegramUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'chat_id' => 'required']);
        TelegramUser::create($request->all());
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'chat_id' => 'required']);
        $user = TelegramUser::findOrFail($id);
        $user->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        TelegramUser::destroy($id);
        return response()->json(['success' => true]);
    }
}
