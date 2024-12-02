<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Blog;

use DB;
use Carbon\Carbon;
use a8worx\Blogs\Models\Blog;

class DeleteBlogAction
{
    public function execute($id)
    {
        // Delete the blog
        $blog = Blog::find($id);

        // Not Found!
        if (!$blog) {
            return null;
        }

        // Delete
        $blog->delete();

        // Return
        return true;
    }
}
