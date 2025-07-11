<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method bool isAdmin() // <-- Вот эта строка самая важная!
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @return \Illuminate\Database\Eloquent\Collection
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Пользователь - админ?
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    // Связи
    public function swipes() { return $this->hasMany(Swipe::class); }
    public function votes() { return $this->hasMany(Vote::class); }
    
    // Понравившиеся события (где был лайк)
    public function favoriteEvents()
    {
        return $this->belongsToMany(Event::class, 'swipes')->wherePivot('liked', true);
    }

    // Система дружбы
    // app/Models/User.php

    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted');
    }

// Отношение для пользователей, которые добавили МЕНЯ в друзья
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->wherePivot('status', 'accepted');
    }
    public function getFriendsAttribute()
    {
        // Проверяем, были ли данные уже загружены, чтобы избежать лишних запросов
        if (! $this->relationLoaded('friendsOfMine')) {
            $this->load('friendsOfMine');
        }
        if (! $this->relationLoaded('friendOf')) {
            $this->load('friendOf');
        }
    
        // Объединяем две коллекции
        return $this->friendsOfMine->merge($this->friendOf);
    }
    
    // Запросы в друзья, которые я отправил
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    // Запросы в друзья, которые мне отправили
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }
}