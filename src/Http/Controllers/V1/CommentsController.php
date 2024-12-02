<?php

namespace a8worx\Blogs\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use a8worx\Blogs\Http\Controllers\Actions\Comments\SearchCommentAction;
use a8worx\Blogs\Http\Controllers\Actions\Comments\MyCommentAction;
use a8worx\Blogs\Http\Controllers\Actions\Comments\StoreCommentAction;
use a8worx\Blogs\Http\Controllers\Actions\Comments\GetCommentByIdAction;
use a8worx\Blogs\Http\Controllers\Actions\Comments\UpdateCommentAction;
use a8worx\Blogs\Http\Controllers\Actions\Comments\DeleteCommentAction;
use a8worx\Blogs\Http\Requests\Comments\StoreCommentRequest;
use a8worx\Blogs\Http\Requests\Comments\UpdateCommentRequest;
use a8worx\Blogs\Http\Requests\Comments\DestroyCommentRequest;
use a8worx\Blogs\Http\Requests\Comments\ShowCommentRequest;
use a8worx\Blogs\Http\Resources\CommentResource;

/**
 * Class CommentsController
 *
 * This controller handles requests related to comments on blogs.
 */
class CommentsController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct(
        SearchCommentAction $searchCommentAction,
        MyCommentAction $myCommentAction,
        StoreCommentAction $storeCommentAction,
        GetCommentByIdAction $getCommentByIdAction,
        UpdateCommentAction $updateCommentAction,
        DeleteCommentAction $deleteCommentAction
    ) {
        $this->searchCommentAction = $searchCommentAction;
        $this->myCommentAction = $myCommentAction;
        $this->storeCommentAction = $storeCommentAction;
        $this->getCommentByIdAction = $getCommentByIdAction;
        $this->updateCommentAction = $updateCommentAction;
        $this->deleteCommentAction = $deleteCommentAction;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexCommentRequest $request)
    {
        // Search comments
        $comments = $this->searchCommentAction->execute($request);

        // Response
        return $this->successResponse(null, $comments);
    }

    /**
     * Retrieve comments by the current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userComments(Request $request)
    {
        // Comments by the current user
        $comments = $this->myCommentAction->execute($request);

        // Transform comments into a resource collection
        $comments = CommentResource::collection($comments);

        // Response
        return $this->successResponse(null, $comments);
    }

    /**
     * Show the form for creating a new comment.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('comments::create');
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param StoreCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentRequest $request)
    {
        // Store the comment
        $comment = $this->storeCommentAction->execute($request->all());

        // Response
        return $this->successResponse(__('main.data_retrieved_successfully'), $comment);
    }

    /**
     * Show a specific comment by ID.
     *
     * @param ShowCommentRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ShowCommentRequest $request, $id)
    {
        // Get the comment by ID
        $comment = $this->getCommentByIdAction->execute($id);

        // Response
        return $this->successResponse(null, $comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('comments::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        // Update Status
        $comment = $this->updateCommentAction->execute($request->id);

        // Response
        return $this->successResponse(__('main.data_retrieved_successfully'), [
            'comment' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyCommentRequest $request, $id)
    {
        // Delete the comment
        $comment = $this->deleteCommentAction->execute($request->id);

        // Not Found
        if (!$comment) {
            return $this->notFoundResponse();
        }

        // Response
        return $this->successResponse(__('main.data_deleted_successfully'), null);
    }
}
