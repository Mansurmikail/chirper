<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * Display the user's following feed.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $followingIds = $user->following()
            ->pluck('following_id');

        $chirps = Chirp::with('user')
            ->where(function ($query) use ($user, $followingIds) {
                $query->where('user_id', $user->id)
                    ->orWhereIn('user_id', $followingIds);
            })
            ->latest()
            ->paginate(10);

        return view('feed.index', [
            'chirps' => $chirps,
        ]);
    }
}