<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

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
     * @return Response
     */
    public function index()
    {
        $blogs = $this->blogRepository->paginate(12);

        return view('blog.index', compact('blogs'));
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
     * GET|HEAD /blog/{id}/show
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
     * Display the specified Blog.
     * GET|HEAD /blog/{id}/edit
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return redirect('404');
        }
        return view('blog.edit', $blog);
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
        $this->blogRepository->update($input, $id);
        return redirect('admin/blog');

    }

    /**
     * Remove the specified Blog from storage.
     * DELETE /blog/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
        return redirect('admin/blog');
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
