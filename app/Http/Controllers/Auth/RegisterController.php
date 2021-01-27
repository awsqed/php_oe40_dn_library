<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->middleware('guest');
        $this->repository = $repository;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(UserRequest $request)
    {
        $user = $this->repository->createUser($request);
        Auth::guard()->login($user);

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect()->route('home');
    }

}
