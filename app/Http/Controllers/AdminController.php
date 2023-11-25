<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\Password;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function users()
    {
        $users = User::all();
        return inertia('User/Index', compact('users'));
    }

    public function userShow(User $user)
    {
        $projects = $user->projects()->get();
        return inertia('User/Show', compact('user', 'projects'));
    }

    public function userDelete(User $user)
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
