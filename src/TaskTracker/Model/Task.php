<?php
declare(strict_types=1);

namespace TaskTracker\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    protected $fillable = ['name','description','status', 'user_id'];

    /*
    * Get Task of User
    *
    */
    public function user()
    {
        return $this->belongsTo('TaskTracker\Model\User');
    }
}
