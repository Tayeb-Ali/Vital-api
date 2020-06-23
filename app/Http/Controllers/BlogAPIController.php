<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\BlogRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;


/**
 * Class BlogAPIController
 * @package App\Http\Controllers\API
 */
class BlogAPIController extends AppBaseController
{
    /** @var  BlogRepository */
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the Blog.
     * GET|HEAD /blog
     **
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $blogs = $this->blogRepository->paginate(15);
    }

    /**
     * Store a newly created Blog in storage.
     * POST /employs
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $blog = $this->blogRepository->createApi($input);
        return $this->sendResponse($blog->toArray(), 'Blog saved successfully');
    }

    /**
     * Display the specified Blog.
     * GET|HEAD /employs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        return $this->sendResponse($blog->toArray(), 'Blog retrieved successfully');
    }

    /**
     * Update the specified Blog in storage.
     * PUT/PATCH /employs/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        $blog = $this->blogRepository->update($input, $id);

        return $this->sendResponse($blog->toArray(), 'Blog updated successfully');
    }

    /**
     * Remove the specified Blog from storage.
     * DELETE /employs/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws Exception
     *
     */
    public function destroy($id)
    {
        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        $blog->delete();

        return $this->sendSuccess('Blog deleted successfully');
    }
}
