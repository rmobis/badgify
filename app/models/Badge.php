<?php

class Badge extends \Eloquent {
	protected $fillable = [];

    public function users() {
        return $this->belongsToMany('User');
    }

    public function achievements() {
        return $this->hasMany('Achievement');
    }

    public function category() {
        return $this->belongsTo('Category');
    }
}
