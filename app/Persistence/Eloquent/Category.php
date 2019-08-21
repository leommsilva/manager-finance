<?php

namespace App\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * Get user.
     */
    public function user()
    {
        return $this->belongsTo('App\Persistence\Eloquent\User');
    }

    /**
     * Get the transactions for the category.
     */
    public function transactions()
    {
        return $this->hasMany('App\Persistence\Eloquent\Transaction');
    }
}
