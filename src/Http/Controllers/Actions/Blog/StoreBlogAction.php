<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Blog;

use a8worx\Blogs\Models\Blog;
use a8worx\Blogs\Models\BlogTranslation;
use a8worx\Blogs\Http\Resources\BlogResource;
use a8worx\Media\Http\Controllers\Actions\Media\MoveMediaAction;

class StoreBlogAction
{
    public function execute($data)
    {
        // Create Blog
        $blog = Blog::create($data);

        // Create Translations
        foreach ($data['trans'] as $translation) {
            $translation['blog_id'] = $blog->id;
            BlogTranslation::insert($translation);
        }


        // Attach the tags to the blog
        if (isset($data['tag_ids'])) {
            $blog->tags()->sync($data['tag_ids']);
        }


        // Create comments for the blog
        if (isset($data['comments'])) {
            foreach ($data['comments'] as $comment) {
                $blog->comments()->create([
                    'content' => $comment['content'],
                    'user_id' => auth()->user()->id,
                    'is_approved' => $comment['is_approved'],
                    'parent_id' => $comment['parent_id'],
                ]);
            }
        }

        // Store the image if provided
        if (isset($data['featured_image_id'])&& !empty($data['featured_image_id'])):
             (new MoveMediaAction)->execute($data['featured_image_id'], $blog, 'blogs.blog.featured_image');
        endif;
        if (isset($data['card_image_id'])&& !empty($data['card_image_id'])):
            (new MoveMediaAction)->execute($data['card_image_id'], $blog, 'blogs.blog.card_image');
       endif;

        // Return Blog Resource
        return new BlogResource($blog);
    }
    
}
