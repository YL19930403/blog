<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Validator;

class Video extends Model
{
    use Searchable;

    protected $fillable = [
        '_id',
        'name',
        'content',
        'cat_id',
        'url',
        'type',
        'status',
        'video_id'
    ];


    public function searchableAs()
    {
        return 'video';
    }

   public function toSearchableArray()
   {
       return [
           'name' => $this->name,
           'content' => $this->content,
       ];
   }


}
