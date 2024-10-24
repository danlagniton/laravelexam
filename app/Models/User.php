<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\UserSaved;

class User extends Model
{
    protected $fillable = ['prefixname', 'firstname', 'middlename', 'lastname', 'suffixname', 'username', 'email', 'password', 'photo', 'type'];

    public function getAvatarAttribute()
    {
        return $this->photo ?? 'default-avatar.png';
    }

    public function getFullnameAttribute()
    {
        return "{$this->firstname} " . ($this->middlename ? substr($this->middlename, 0, 1) . '. ' : '') . "{$this->lastname}";
    }

    public function getMiddleinitialAttribute()
    {
        return $this->middlename ? substr($this->middlename, 0, 1) . '.' : '';
    }
    
    protected static function booted()
    {
        static::saved(function ($user) {
            event(new UserSaved($user));
        });
    }
    
}
