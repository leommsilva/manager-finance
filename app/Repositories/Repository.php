<?php namespace App\Repositories;

class Repository
{

    protected $user = null;

    public function __construct()
    {
        $this->user = auth()->user();
    }

}
