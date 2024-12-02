<?php

namespace a8worx\Blogs\Http\Controllers\Actions\BlogCategories;

use a8worx\Blogs\BlogCategory;
use a8worx\Blogs\BlogCategoryTranslation;
use DB;
use Carbon\Carbon;
use a8worx\Blogs\Http\Resources\BlogCategoryResource;

class CreateBlogCategoryAction
{
    public function execute(array $data): BlogCategoryResource
    {
        $created_at = Carbon::now()->toDateTimeString();

        // Create the blog category
        $blog_category = BlogCategory::create($data);

        // Create translations
        for ($i = 0; $i < count($data['translations']); $i++) {
            // To overcome composite primary key laravel insertion issue
            $blog_category_id = $blog_category->id;
            $language_id = $data['translations'][$i]['language_id'];
            $title = $data['translations'][$i]['title'];

            if ($language_id == 1) {
                $slug = str_slug($title);
            }

            DB::table('blog_category_trans')->insert([
                'blog_category_id' => $blog_category_id,
                'language_id' => $language_id,
                'title' => $title,
                'created_at' => $created_at
            ]);
        }

        // Trigger update event on blog category to cache its values
        $blog_category->update([
            'slug' => isset($slug) ? $slug : ''
        ]);

        // Reload the instance
        $blog_category = BlogCategory::find($blog_category->id);

        // Transform the result
        $blog_category = new BlogCategoryResource($blog_category);

        return $blog_category;
    }
}
