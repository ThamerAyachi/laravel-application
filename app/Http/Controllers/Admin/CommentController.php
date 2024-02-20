<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateComment;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateComment $request, $comment_id)
    {
        $validated = $request->validated();
        $comment = Comment::findOrFail($comment_id);
        $commentRepository = new CommentRepository($comment);
        return response()->json($commentRepository->update($validated), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $commentRepository = new CommentRepository($comment);
        $commentRepository->delete();
        return response()->json();
    }
}
