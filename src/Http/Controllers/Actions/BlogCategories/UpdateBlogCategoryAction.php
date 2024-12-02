<?php

namespace a8worx\Blogs\Http\Controllers\Actions\BlogCategories;

use a8worx\Blogs\BlogCategory;
use a8worx\Blogs\BlogCategoryTranslation;
use DB;
use Carbon\Carbon;
use a8worx\Blogs\Http\Resources\BlogCategoryResource;

class UpdateBlogCategoryAction
{
    public function execute($id, array $data): BlogCategoryResource
    {
        $created_at = Carbon::now()->toDateTimeString();
        $updated_at = Carbon::now()->toDateTimeString();

        // Get the blog category
        $blog_category = BlogCategory::find($id);

        // Update/Create translations
        for ($i = 0; $i < count($data['translations']); $i++) {
            // To overcome composite primary key laravel update issue
            $blog_category_id = $id;
            $language_id = $data['translations'][$i]['language_id'];
            $title = $data['translations'][$i]['title'];

            // Check if translation exists
            $blog_category_trnaslation = BlogCategoryTranslation::where('blog_category_id', $blog_category_id)->where('language_id', $language_id)->first();

            if ($language_id == 1) {
                $slug = str_slug($title);
            }

            if ($blog_category_trnaslation) {
                DB::table('blog_category_trans')->where('blog_category_id', $blog_category_id)->where('language_id', $language_id)->update(
                    [
                        'title' => $title,
                        'updated_at' => $updated_at
                    ]
                );
            } else {
                DB::table('blog_category_trans')->insert([
                    'blog_category_id' => $blog_category_id,
                    'language_id' => $language_id,
                    'title' => $title,
                    'created_at' => $created_at
                ]);
            }
        }

        // Trigger update event on blog category to cache its values
        $blog_category->update([
            'order' => isset($data['order']) ? $data['order'] : 0,
            'updated_at' => $updated_at,
            'slug' => isset($slug) ? $slug : ''

        ]);

        // Reload the instance
        $blog_category = BlogCategory::find($blog_category->id);

        // Transform the result
        $blog_category = new BlogCategoryResource($blog_category);

        return $blog_category;
    }
}
