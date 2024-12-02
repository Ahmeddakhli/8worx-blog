<?php

namespace a8worx\Blogs\Http\Controllers\Actions\Blog;


use Illuminate\Support\Facades\App;
use a8worx\Blogs\Http\Resources\BlogResource;
use a8worx\Blogs\Models\Blog;
use a8worx\Languages\Http\Controllers\Actions\Languages\GetLanguageByCodeAction;

class GetBlogsAction
{
    public function execute($request)
    {
        $language_id = 1;

        // Search Blogs
        $blogs = (new Blog)->newQuery();
        
        if ($request->has('is_published') && $request->input('is_published') == true) {
            $blogs = $blogs->published();
        }
        
        if (!empty($request->filters)) {
            if (!empty($request->filters['query'])) {
                $query = $request->filters['query'];
                $blogs = $blogs->whereHas('trans', function ($data) use ($query) {
                    $data->where('title', 'LIKE', "%{$query}%");
                    // ->orWhere('description', 'like', "%{$query}%");
                });
            }
        }

        if ($request->has('category_slug') && !empty($request->category_slug)) :
            $slug = $request->category_slug;
            $blogs = $blogs->whereHas('category', function ($category) use ($slug) {
                $category->whereHas('translations', function ($trans) use ($slug) {
                    $trans->where('slug', $slug);
                });
            });
        endif;

        if ($request->has('sort_field') && !empty($request->input('sort_field')) && !empty($request->sort_field)) :
            $sortOrder = (!isset($request->sort_order) || $request->sort_order == 1) ? 'ASC' : 'DESC';

            if ($request->sort_field === 'category.title') {
                $blogs = $blogs->join('lookups', 'blogs.category_id', '=', 'lookups.id')
                    ->orderBy('lookups.name', $sortOrder)
                    ->select('blogs.*');
            } elseif ($request->sort_field === 'title') {
                $blogs = $blogs->join('blog_trans', 'blogs.id', '=', 'blog_trans.blog_id')
                    ->where('blog_trans.language_id', '=', $language_id)
                    ->orderBy('blog_trans.title', $sortOrder)
                    ->select('blogs.*');
            } elseif ($request->sort_field === 'creator.username') {
                $blogs = $blogs->join('users', 'blogs.created_by', '=', 'users.id')
                    ->orderBy('users.username', $sortOrder)
                    ->select('blogs.*');
            } else {
                $blogs = $blogs->orderBy($request->sort_field, $sortOrder);
            }
        endif;

        if ($request->has('is_paginated') && $request->input('is_paginated') == false) {
            return  BlogResource::collection($blogs->limit($request->limit ?? 10)->get());
        }

        $blogs = BlogResource::collection(addPagination($blogs, $request));
        return  addPaginationStatistics($blogs);
    }
}
