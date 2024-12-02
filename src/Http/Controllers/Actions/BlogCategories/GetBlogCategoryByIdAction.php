<?php

namespace a8worx\Blogs\Http\Controllers\Actions\BlogCategories;

use a8worx\Blogs\BlogCategory;
use a8worx\Blogs\Http\Resources\BlogCategoryResource;

class GetBlogCategoryByIdAction
{
    public function execute($id)
    {
        // Find blog category
        $blog_category = BlogCategory::find($id);

        return new BlogCategoryResource($blog_category);
    }
}
