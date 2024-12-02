<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Comments;

use a8worx\Blogs\Http\Resources\CommentResource;
use a8worx\Blogs\Models\Comment;

class GetCommentByIdAction
{
    public function execute($id)
    {
        $comment = Comment::find($id);

          // Not Found!
          if (!$comment) {
            return null;
        }
        
        return new CommentResource($comment);
    }
}
