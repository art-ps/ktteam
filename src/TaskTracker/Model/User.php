<?php
declare(strict_types=1);

namespace TaskTracker\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    /**
    * @var array
    */
    protected $fillable = [
           'name', 'email', 'password'
       ];

    /**
    * @var array
    */
    protected $hidden = [
           'password'
       ];

    /*
    * Get Task of User
    *
    */
    public function task()
    {
        return $this->hasMany('TaskTracker\Model\Task');
    }
}
