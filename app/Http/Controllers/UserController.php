<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Password;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        return inertia('Forms/UserCreateForm');
    }

    public function userShow(User $user)
    {
        $projects = ProjectResource::make($user->projects()->get())->resolve();
        $user = UserResource::make($user)->resolve();
        return inertia('User/Show', compact('user', 'projects'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $password = Str::random(11);
        $data['password'] = $password;
        $user = User::query()->create($data);
        return redirect()->route('user.show', $user);
    }

    public function userAccess(Project $project)
    {
        $users = User::query()->with('projects')->whereNot('name', 'admin')->get();
        $users = $users->map(function ($user) use ($project) {
            $user->isAttached = $user->projects->contains('id', $project->id);
            return $user;
        });
        $users = UserResource::collection($users)->resolve();
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/AddUser', compact('project', 'users'));
    }

    public function index()
    {
        $users = User::query()->whereNot('id', auth()->id())->get();
        $users = UserResource::collection($users)->resolve();
        return inertia('User/Index', compact('users'));
    }

    public function show(User $user)
    {
        $projects = ProjectResource::collection($user->projects()->get())->resolve();
        $user = UserResource::make($user)->resolve();
        return inertia('User/Show', compact('user', 'projects'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'Пользователь был успешно удален'
        ]);
    }

    public function removeAccess(User $user, Project $project)
    {
        $user->projects()->detach($project);

        return response()->json([
            'message' => "Пользователь $user->name больше не имеет доступа к проекту $project->name"
        ]);
    }



}
