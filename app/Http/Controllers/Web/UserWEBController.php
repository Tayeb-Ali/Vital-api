<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Repositories\UserRepository;
use App\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

/**
 * Class UserAPIController
 * @package App\Http\Controllers\API
 */
class UserWEBController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the Blog.
     * GET|HEAD /users
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepository->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created Blog in storage.
     * POST /users
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->image->extension()) {
            $image = $this->saveImage($request);
            $user = new User();
            $user->fill($input);
            $user->image = $image;
            $user->password = app('hash')->make($input->password);
            $user->save();
            return redirect('admin/users');
        }
        $user = new User();
        $user->fill($input);
        $user->password = app('hash')->make($input->password);
        $user->save();
        return redirect('admin/users');

    }


    /**
     * Display the specified Blog.
     * GET|HEAD /users/{id}/show
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */

        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return redirect('404');
        }
        return view('usersview', $user);
    }

    /**
     * Display the specified Blog.
     * GET|HEAD /users/{id}/create
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Display the specified Blog.
     * GET|HEAD /users/{id}/edit
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var User $user */

        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return redirect('404');
        }
        return view('users.edit', $user);
    }

    /**
     * Update the specified Blog in storage.
     * PUT/PATCH /users/{id}/update
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var User $user */

        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return redirect('404');
        }
        $this->userRepository->update($input, $id);
        return redirect('admin/users');

    }

    /**
     * Remove the specified Blog from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @throws Exception
     *
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('Blog not found');
        }

        $user->delete();
        return redirect('admin/users');
    }

    public function saveImage($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $random . '_users' . $request->image->extension();
            $image->move(base_path() . '/public/users/', $name);
            $name = url("profile/$name");
            return $name;
        }
        return false;
    }
}
