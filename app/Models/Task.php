<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'due_date',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * If you want to the normal user to see, update, delete only task they own
     * uncomment the below code but doing this will fails the two pest test
     */
    // protected static function booted()
    // {
    //     self::addGlobalScope(function (Builder $query) {

    //         if (!auth()->check())
    //         {
    //             return;
    //         }

    //         $user = auth()->user();

    //         if (
    //             $user->role_id !== Role::Administrator->value &&
    //             $user->role_id !== Role::Manager->value
    //         )
    //         {
    //             $query->where('user_id', auth()->id());
    //         }
    //     });
    // }
}
