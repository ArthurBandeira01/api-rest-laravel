<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\Response;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected User $user
    ){

    }
    public function index()
    {
        $users = $this->user->paginate();

        return UserResource::collection($users);
    }

    public function store(StoreUpdateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $user = $this->user->create($data);

        return new UserResource($user);
    }

    public function show(string $id)
    {
        $user = $this->user->findOrFail($id);

        return new UserResource($user);
    }

    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id);

        $data = $request->validated();

        if($request->password)
            $data['password'] = bcrypt($request->password);

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();

        return response()->json([], 204);
    }
}
