<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Chirp $chirp): RedirectResponse
    {
        $user = $request->user();

        $like = $chirp->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            return redirect()
                ->back()
                ->with('success', 'Chirp unliked.');
        }

        $chirp->likes()->create([
            'user_id' => $user->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Chirp liked.');
    }
}