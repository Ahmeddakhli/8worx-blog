<?php

namespace a8worx\Blogs\Http\Controllers\Actions\BlogCategories;

use Cache;
use a8worx\Blogs\BlogCategory;
use a8worx\Blogs\Http\Resources\BlogCategoryResource;

class GetBlogCategoriesAction
{
    public function execute()
    {
        // Get the blog categories
        $blog_category = BlogCategory::all();

        // Transform the  blog categories
        $blog_category = BlogCategoryResource::collection($blog_category);

        // Return the result
        return $blog_category;
    }
}
