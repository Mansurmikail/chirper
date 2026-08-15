<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Follow or unfollow a user.
     */
    public function toggle(Request $request, User $user): RedirectResponse
    {
        $currentUser = $request->user();

        // Prevent users from following themselves.
        if ($currentUser->id === $user->id) {
            return redirect()
                ->back()
                ->with('error', 'You cannot follow yourself.');
        }

        $follow = $currentUser->following()
            ->where('following_id', $user->id)
            ->first();

        if ($follow) {
            $follow->delete();

            return redirect()
                ->back()
                ->with('success', 'Unfollowed successfully.');
        }

        $currentUser->following()->create([
            'following_id' => $user->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Followed successfully.');
    }
}