<?php

namespace App\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'value',
        'is_recurrent',
        'month',
        'year',
        'is_verified',
    ];

    /**
     * Get user.
     */
    public function user()
    {
        return $this->belongsTo('App\Persistence\Eloquent\User');
    }

    /**
     * Get user.
     */
    public function category()
    {
        return $this->belongsTo('App\Persistence\Eloquent\Category');
    }
}
