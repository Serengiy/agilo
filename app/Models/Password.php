<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Password extends Model
{
    use HasFactory;

    protected $with=['project'];
    protected $fillable =[
      'login',
      'password',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public static function accessedPassword()
    {
        if(isAdmin()){
            return Password::all();
        }
        $passwords = Password::whereHas('project.users', function ($query) {
            $query->where('users.id', auth()->id());
        })->get();

        return $passwords;
    }

    public static function projectFilter()
    {
        return Password::query()->whereHas('project', function (Builder $query){
            $query->whereIn('name', request('projects'));
        });
    }
}
