<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Kerjasama;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'role_id',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
    public function repository()
    {
        return $this->hasMany('App\Models\Repository', 'user_id');
    }
    public function kerjasamaLegal()
    {
        return Kerjasama::where('step', '=', '1')
            ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
            ->orWhereNull('target_reviewer_id')
            ->where('step', '=', '1')
            ->get()
            ->count();
    }

    public function kerjasamaWadir()
    {
        return Kerjasama::where('step', '=', '3')
            ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
            ->orWhereNull('target_reviewer_id')
            ->where('step', '=', '3')
            ->get()
            ->count();
    }

    public function kerjasamaDirektur()
    {
        return Kerjasama::where('step', '=', '5')
            ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
            ->orWhereNull('target_reviewer_id')
            ->where('step', '=', '5')
            ->get()
            ->count();
    }
    public function kerjasamaAdmin()
    {
        return Kerjasama::where('step', '=', '5')
            ->where('target_reviewer_id', 'like', '%' . Auth::user()->id . '%')
            ->orWhereNull('target_reviewer_id')
            ->where('step', '=', '5')
            ->get()
            ->count();
    }
}
