<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Comments;

use DB;
use Carbon\Carbon;
use a8worx\Blogs\Models\Comment;

class DeleteCommentAction
{
    public function execute($id)
    {
        // Delete the comment
        $comment = Comment::find($id);

        // Not Found!
        if (!$comment) {
            return null;
        }

        // Delete
        $comment->delete();

        // Return
        return true;
    }
}
