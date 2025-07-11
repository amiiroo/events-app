<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    public $table = 'friendships';

    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    protected $guarded = [];
}