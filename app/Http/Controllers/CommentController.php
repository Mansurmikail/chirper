<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, Chirp $chirp): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $chirp->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('chirps.index')
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->route('chirps.index')
            ->with('success', 'Comment deleted successfully.');
    }
}