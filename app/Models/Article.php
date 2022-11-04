<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    public static function filterQuery(array $input)
    {
        $query = Article::query();
        if( isset($input['search']) ){
            $query = $query->where(function($query) use($input){
                $searchString = '%'.$input['search'].'%';
                $query->where('url', 'like', $searchString );
                $query->orWhere('source', 'like', $searchString );
            });
        }   
        return $query;
    }
}
