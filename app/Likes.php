<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Likes extends Model
{
    protected $collection = 'likes';
}
