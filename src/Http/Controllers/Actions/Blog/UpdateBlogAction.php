<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Blog;

use a8worx\Blogs\BlogTranslation;
use DB;
use Carbon\Carbon;
use a8worx\Attachments\Entities\Attachmentable;
use a8worx\Attachments\Http\Controllers\Actions\StoreAttachmentAction;
use a8worx\Blogs\Http\Resources\BlogResource;
use a8worx\Blogs\Models\Blog;
use a8worx\Media\Http\Controllers\Actions\Media\MoveMediaAction;

class UpdateBlogAction
{
    public function execute($data)
    {
        // Get Data
        $blog = Blog::find($data->id);

        if ($blog) :
            // Store the image if provided
            if (isset($data->featured_image_id)) :
                (new MoveMediaAction)->execute($data->featured_image_id, $blog, 'blogs.blog.featured_image');
            endif;
            if (isset($data->card_image_id)) :
                (new MoveMediaAction)->execute($data->card_image_id, $blog, 'blogs.blog.card_image');
            endif;
            // Store Trans
            if (isset($data->trans)) :
                foreach ($data->trans as $blog_trans) :
                    // Update or create the translation for the specified language
                    $blog->trans()->updateOrCreate(['language_id' => $blog_trans['language_id']], $blog_trans);
                endforeach;
            endif;
            // Store Tags
            if (isset($data->tag_ids)) :
                $blog->tags()->sync($data->tag_ids);
            endif;

        endif;
        $blog->update($data->all());

        // Resource
        $blog = new BlogResource($blog);

        // Return
        return $blog;
    }
}
