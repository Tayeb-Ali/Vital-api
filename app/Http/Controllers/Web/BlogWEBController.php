<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Class BlogAPIController
 * @package App\Http\Controllers\API
 */
class BlogWEBController extends AppBaseController
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
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $blogs = $this->blogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return view('blog.index', $blogs);
    }

    /**
     * Store a newly created Blog in storage.
     * POST /blog
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $image = $this->saveImage($request);
        if ($image) {
            $request->merge(['image' => $image]);
            $this->blogRepository->createApi($input);
            return view('blog.index', 'Blog saved successfully');
        } else {
            $this->blogRepository->createApi($input);
            return view('blog.index', 'Blog saved successfully');
        }

    }

    /**
     * Display the specified Blog.
     * GET|HEAD /blog/{id}
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
            return redirect('404');
        }
        return view('blog.view', $blog);
    }

    /**
     * Update the specified Blog in storage.
     * PUT/PATCH /blog/{id}
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
            return redirect('404');
        }
        $blog = $this->blogRepository->update($input, $id);
        return view('blog.view', $blog);
    }

    /**
     * Remove the specified Blog from storage.
     * DELETE /blog/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
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

    public function saveImage($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $random . '_blog.' . $request->cv->extension();
            $image->move(public_path() . '/blog/', $name);
            $name = url("blog/$name");

            return $name;
        }
        return false;
    }
}
