<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Comments;

use a8worx\Blogs\Models\Comment;

class StoreCommentAction
{
    public function execute($data)
    {
        // Create comment
        $data['user_id'] = auth()->user()->id;
        
        $comment = Comment::create($data);

        // Store the image if provided

        // Return v Resource
        return $comment;

    }
}
