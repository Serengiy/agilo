<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Resources\PasswordResource;
use App\Http\Resources\ProjectResource;
use App\Models\Password;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::accessedProjects();
        $projects = ProjectResource::collection($projects)->resolve();
        return inertia('Project/Index', compact('projects'));
    }

    public function create()
    {
        return inertia('Forms/ProjectCreateForm');
    }

    public function show(Project $project)
    {
        $passwords = PasswordResource::collection($project->passwords()->get())->resolve();
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/Show', compact('project', 'passwords'));
    }

    public function store(ProjectStoreRequest $request)
    {
        $data = $request->validated();
        $project = Project::query()->firstOrCreate([
            'name' => $data['name'],
        ],[
            'name' => $data['name'],
            'user_id' => auth()->id()
            ]
        );

        $project->users()->attach(auth()->user());

        $project = ProjectResource::make($project)->resolve();
        return redirect()->route('project.show', $project['id']);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' => 'Проект удален'
        ]);
    }

    public function projectToggle(Project $project, User $user)
    {
        $user->accessedProjects()->toggle($project);
        return response()->json('success');
    }

    public function rightsAccess(Project $project)
    {

        $users = User::query()->whereNot('id', auth()->id())->whereNot('role', UserRoleEnum::ADMIN)->get();
        $users = $users->map(function ($user) use ($project) {
            $user->isAttached = $user->accessedProjects->contains('id', $project->id);
            return $user;
        });
        $project = ProjectResource::make($project)->resolve();
        return inertia('Project/AddUser', compact('project', 'users'));
    }
}
