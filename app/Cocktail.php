<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
	public $name;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cocktail_name', 'description', 'recipe', 'img_path',
    ];

    public function getName(){
    	return $this->name;
    }

}
