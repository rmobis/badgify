<?php

class Achievement extends \Eloquent {
	protected $fillable = [];

    public function getRulesAttribute() {
        return array_map(function ($rules) {
            return explode(':', $rules);
        }, explode(';', $this->attributes['rules']));
    }
}
