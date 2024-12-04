<?php

namespace a8worx\Blogs\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use a8worx\Blogs\Http\Controllers\Actions\Blog\StoreBlogAction;
use a8worx\Blogs\Http\Controllers\Actions\Blog\DeleteBlogAction;
use a8worx\Blogs\Http\Controllers\Actions\Blog\GetBlogsAction;
use a8worx\Blogs\Http\Controllers\Actions\Blog\UpdateBlogAction;
use a8worx\Blogs\Http\Requests\Blog\StoreBlogRequest;
use a8worx\Blogs\Http\Requests\Blog\DeleteBlogRequest;
use a8worx\Blogs\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Helpers\ServiceResponse;
// use a8worx\Blogs\Http\Controllers\Actions\Blog\GetFeaturedBlogsAction;
use a8worx\Blogs\Http\Controllers\Actions\Blog\GetBlogByIdAction;

/**
 * Class BlogsController
 *
 * This controller handles requests related to Blogs.
 */
class BlogsController extends Controller
{
    /**
     * StoreBlogAction instance.
     *
     * @var StoreBlogAction
     */
    private $storeBlogAction;

    /**
     * UpdateBlogAction instance.
     *
     * @var UpdateBlogAction
     */
    private $updateBlogAction;

    /**
     * DeleteBlogAction instance.
     *
     * @var DeleteBlogAction
     */
    private $deleteBlogAction;

    /**
     * GetBlogByIdAction instance.
     *
     * @var GetBlogByIdAction
     */
    private $getBlogByIdAction;

    /**
     * GetBlogsAction instance.
     *
     * @var GetBlogsAction
     */
    private $getBlogsAction;

    /**
     * GetFeaturedBlogsAction instance.
     *
     * @var GetFeaturedBlogsAction
     */
    private $getFeaturedBlogsAction;

    /**
     * Constructor function
     *
     * @param StoreBlogAction $storeBlogAction
     * @param UpdateBlogAction $updateBlogAction
     * @param DeleteBlogAction $deleteBlogAction
     * @param GetBlogByIdAction $getBlogByIdAction
     * @param GetBlogsAction $getBlogsAction
     * @param GetFeaturedBlogsAction $getFeaturedBlogsAction
     */
    // GetFeaturedBlogsAction $getFeaturedBlogsAction

    public function __construct(
        StoreBlogAction $storeBlogAction,
        UpdateBlogAction $updateBlogAction,
        DeleteBlogAction $deleteBlogAction,
        GetBlogByIdAction $getBlogByIdAction,
        GetBlogsAction $getBlogsAction
    ) {
        $this->storeBlogAction = $storeBlogAction;
        $this->updateBlogAction = $updateBlogAction;
        $this->deleteBlogAction = $deleteBlogAction;
        $this->getBlogByIdAction = $getBlogByIdAction;
        $this->getBlogsAction = $getBlogsAction;
        // $this->getFeaturedBlogsAction = $getFeaturedBlogsAction;
    }

    /**
     * Store a new blog.
     *
     * @param StoreBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBlogRequest $request)
    {
        // Create a new blog
        $blog = $this->storeBlogAction->execute($request->input());

        // Return the response
        return $this->successResponse(__('main.data_retrieved_successfully'), $blog);
    }

    /**
     * Update a blog.
     *
     * @param UpdateBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBlogRequest $request)
    {
        // Update the blog
        $blog = $this->updateBlogAction->execute($request);

        // Return the response
        return $this->successResponse(__('main.data_retrieved_successfully'), $blog);
    }

    /**
     * Delete a blog.
     *
     * @param DeleteBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteBlogRequest $request)
    {
        // Delete the blog
        $blog = $this->deleteBlogAction->execute($request->input('id'));

        // Not Found
        if (!$blog) {
            return $this->notFoundResponse();
        }

        // Response
        return $this->successResponse(__('main.data_deleted_successfully'), null);
    }

    /**
     * Show a blog by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Get the blog by ID
        $blog = $this->getBlogByIdAction->execute($id);

        // Not Found
        if (!$blog) {
            return $this->notFoundResponse();
        }

        // Response
        return $this->successResponse(null, $blog);
    }

    /**
     * Index blogs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get the list of blogs
        $blogs = $this->getBlogsAction->execute($request);

        // Return the response
        return $this->successResponse(null, $blogs);
    }

    /**
     * Index blogs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexFront(Request $request)
    {
        return "    all blogs";
        // Add 'is_front' to the request with a value of true or false
        $request->merge(['is_published' => true]);

        // Get the list of blogs
        $blogs = $this->getBlogsAction->execute($request);

        // Return the response
        return $this->successResponse(null, $blogs);
    }

    /**
     * Retrieve featured blogs for the home page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function homeBlogs(Request $request)
    // {
    //     // Get featured blogs
    //     $blogs = $this->getFeaturedBlogsAction->execute();

    //     // Return the response
    //     return $this->successResponse('Featured blogs retrieved successfully', $blogs);
    // }
}
