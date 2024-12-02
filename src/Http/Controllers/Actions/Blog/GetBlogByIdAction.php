<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Blog;

use a8worx\Blogs\Models\Blog;
use a8worx\Blogs\Http\Resources\BlogResource;

class GetBlogByIdAction
{
    public function execute($id)
    {
        // TODO - Cache It

        // Find
        $blog = Blog::find($id);

        // Not Found!
        if (!$blog) {
            return null;
        }

        // Resource
        $blog = new BlogResource($blog);

        // Return
        return $blog;
    }
}
