<?php

namespace a8worx\Blogs\Http\Controllers\Actions\BlogCategories;

use a8worx\Blogs\BlogCategory;
use DB;
use Carbon\Carbon;

class DeleteBlogCategoryAction
{
    public function execute($id)
    {
        // Get the blog category
        $blog_category = BlogCategory::find($id);

        // Delete the translations manually to overcome laravel issue with composite primary key
        $blog_category_translations = $blog_category->translations;
        foreach ($blog_category_translations as $blog_category_translation) {
            $deleted_at = Carbon::now()->toDateTimeString();

            $blog_category_id = $blog_category_translation->blog_id;
            $language_id = $blog_category_translation->language_id;

            // Delete the translation
            DB::table('blog_category_trans')->where('blog_category_id', $blog_category_id)->where('language_id', $language_id)->update([
                'deleted_at' => $deleted_at
            ]);
        }

        // Delete the blog
        $blog_category->delete();

        // Return the result
        return null;
    }
}
