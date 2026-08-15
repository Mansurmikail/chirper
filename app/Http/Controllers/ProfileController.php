<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        return view('profile.show', [
            'user' => $user,
            'chirps' => $user->chirps()->latest()->paginate(10),
        ]);
    }

    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Profile updated successfully.');
    }
}