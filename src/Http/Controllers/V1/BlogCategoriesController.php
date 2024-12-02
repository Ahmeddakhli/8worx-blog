<?php

namespace a8worx\Blogs\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use a8worx\Blogs\Http\Controllers\Actions\BlogCategories\CreateBlogCategoryAction;
use a8worx\Blogs\Http\Controllers\Actions\BlogCategories\DeleteBlogCategoryAction;
use a8worx\Blogs\Http\Controllers\Actions\BlogCategories\GetBlogCategoriesAction;
use a8worx\Blogs\Http\Controllers\Actions\BlogCategories\UpdateBlogCategoryAction;
use a8worx\Blogs\Http\Requests\BlogCategories\CreateBlogCategoryRequest;
use a8worx\Blogs\Http\Requests\BlogCategories\DeleteBlogCategoryRequest;
use a8worx\Blogs\Http\Requests\BlogCategories\GetCategoriesRequest;
use a8worx\Blogs\Http\Requests\BlogCategories\UpdateBlogCategoryRequest;
use a8worx\Blogs\Http\Resources\BlogCategoryResource;
use a8worx\Blogs\BlogCategory;
use App\Http\Helpers\ServiceResponse;
use Carbon\Carbon;
use Auth, Lang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Language;

class BlogCategoriesController extends Controller
{
    /**
     * Store blog category
     *
     * @param  [integer] order
     * @param  [array] translations
     * @return [json] ServiceResponse object
     */
    public function store(CreateBlogCategoryRequest $request, CreateBlogCategoryAction $action)
    {
        // Create the blog category
        $blog_category = $action->execute($request->except([]));

        // Return the response
        $resp = new ServiceResponse;
        $resp->message = 'Blog category created successfully';
        $resp->status = true;
        $resp->data = $blog_category;
        return response()->json($resp, 200);
    }
    /**
     * Update blog category
     *
     * @param  [integer] id
     * @param  [integer] order
     * @param  [array] translations
     * @return [json] ServiceResponse object
     */
    public function update(UpdateBlogCategoryRequest $request, UpdateBlogCategoryAction $action)
    {
        // Update the blog category
        $blog_category = $action->execute($request->input('id'), $request->except(['id']));

        // Return the response
        $resp = new ServiceResponse;
        $resp->message = 'Blog category updated successfully';
        $resp->status = true;
        $resp->data = $blog_category;
        return response()->json($resp, 200);
    }
    /**
     * Delete blog category
     *
     * @param  [integer] id
     * @return [json] ServiceResponse object
     */
    public function delete(DeleteBlogCategoryRequest $request, DeleteBlogCategoryAction $action)
    {
        // Delete the blog category
        $action->execute($request->input('id'));

        // Return the response
        $resp = new ServiceResponse;
        $resp->message = 'Blog category deleted successfully';
        $resp->status = true;
        $resp->data = null;
        return response()->json($resp, 200);
    }

    /**
     * Index blogs
     * @return Response
     */
    public function index(Request $request, GetBlogCategoriesAction $action)
    {
        // Get the blog categories
        $blog_categorys = $action->execute();

        // Return the response
        $resp = new ServiceResponse;
        $resp->message = 'Blog categories retrieved successfully';
        $resp->status = true;
        $resp->data = $blog_categorys;
        return response()->json($resp, 200);
    }
}
