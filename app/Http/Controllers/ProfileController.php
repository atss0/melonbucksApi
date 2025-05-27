<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'surname' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $user = $request->user();
        $user->update($request->only('name', 'surname', 'phone'));

        return response()->json(['message' => 'Profil güncellendi.', 'user' => $user]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = $path;
        $user->save();

        return response()->json(['message' => 'Profil fotoğrafı yüklendi.', 'avatar_url' => asset('storage/' . $path)]);
    }

    public function deleteAvatar(Request $request)
    {
        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
        }

        return response()->json(['message' => 'Profil fotoğrafı silindi.']);
    }
}