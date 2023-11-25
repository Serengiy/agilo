<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id'
    ];

    public function passwords():HasMany
    {
        return $this->hasMany(Password::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function accessedProjects()
    {
        if (isAdmin()){
            return Project::query()->withCount('passwords')->get();
        }
        return Project::query()->whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->withCount('passwords')->get();
    }

}
