<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordStoreRequest;
use App\Http\Resources\PasswordResource;
use App\Http\Resources\ProjectResource;
use App\Models\Password;
use App\Models\Project;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function index()
    {
        $passwords = Password::accessedPassword();
        $passwords = PasswordResource::collection($passwords)->resolve();
        $projects = ProjectResource::collection(Project::accessedProjects())->resolve();

        if (request()->has('projects')){
            if(request('projects') === 'none'){
                return response()->json([
                   'passwords' => $passwords
                ]);
            }
            return response()->json([
               'passwords' => PasswordResource::collection(Password::projectFilter()->get())->resolve()
            ]);
        }
        return inertia('Home', compact('passwords', 'projects'));
    }

    public function create(?Password $password)
    {
        $project =  Project::find(request()->get('project'));
        $project = $project ? ProjectResource::make($project)->resolve() : null;
        $projects = ProjectResource::collection(Project::all())->resolve();

        return inertia('Forms/PasswordCreateForm', compact('projects', 'password', 'project'));
    }

    public function store(PasswordStoreRequest $request)
    {
        $data = $request->validated();
        $project = Project::query()->where('name', $data['project'])->first();
        unset($data['project']);
        $password = $project->passwords()->updateOrCreate([
            'id' => $data['id']
        ], $data);
        return redirect()->route('project.show', $project);
    }

    public function destroy(Password $password)
    {
        $password->delete();
        return response()->json([
            'message' => 'Пароль был удален из проекта'
        ]);
    }
    public function passwordGenerate(Request $request)
    {

        return response()->json([
            'password'=> Str::random($request->input('digits'))
        ]);
    }
}
