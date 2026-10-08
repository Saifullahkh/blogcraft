<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(ProfileUpdateRequest $request, ImageUploadService $images)
    {
        $user = $request->user();
        $data = $request->validated();
        $data['avatar'] = $images->replace($user->avatar, $request->file('avatar'), 'avatars');

        $user->update($data);

        return back()->with('success', 'Profile updated.');
    }

    public function password(PasswordUpdateRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return back()->with('success', 'Password changed.');
    }

    public function comments()
    {
        $comments = auth()->user()
            ->comments()
            ->with('post')
            ->latest()
            ->paginate(12);

        return view('profile.comments', compact('comments'));
    }
}
