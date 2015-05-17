<?php

class Category extends \Eloquent {
	protected $fillable = [];

    public function badges() {
        return $this->hasMany('Badge');
    }
}
