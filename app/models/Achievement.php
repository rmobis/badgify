<?php

use SammyK\FacebookQueryBuilder\GraphObject;

class Achievement extends \Eloquent {
    protected $fillable = [];

    public function users() {
        return $this->belongsToMany('User');
    }

    public function badge() {
        return $this->belongsTo('Badge');
    }

    public function getRulesAttribute() {
        return array_map(function ($rules) {
            return explode(':', $rules);
        }, explode(';', $this->attributes['rules']));
    }

    public function validateGraphObject(GraphObject $obj) {
        $rules = $this->rules;

        foreach ($rules as $rule) {
            $ruleMethod = 'validate' . studly_case(array_shift($rule));

            if (! $this->{$ruleMethod}($obj, ...$rule)) {
                return false;
            }
        }

        return true;
    }

    public function validatePlace($obj, $placeId) {
        return $obj->has('place') && $obj['place']['id'] === $placeId;
    }

    public function validateOtherCity($obj){
        if(!$obj->has('place')){
            return false;
        }

        $city = Facebook::object('me')->fields('location')->get();

        $arrayName = explode(', ',$city['location']['name']);

        return $arrayName[0] !== $obj['place']['location']['city'];
    }

    public function validateContent($obj, $content) {
        return $obj->has('message') && strpos($obj['message'], $content) !== false;
    }

    public function validateHashtag($obj, $hashtag) {
        return $this->validateContent($obj, '#' . $hashtag);
    }

    public function validateTaggedPerson($obj, $personName) {
        if ($obj->has('with_tags')) {
            foreach ($obj['with_tags'] as $tag) {
                if ($tag['name'] === $personName) {
                    return true;
                }
            }
        }

        return false;
    }

    public function validateIsType($obj, $type) {
        return $obj->has('type') && $obj['type'] === $type;
    }

    public function validateHasVideo($obj) {
        return $this->validateIsType($obj, 'video');
    }

    public function validateHasPicture($obj) {
        return $this->validateIsType($obj, 'photo');
    }

    public function validateVideoLength($obj, $length) {
        if (! $this->validateHasVideo($obj)) {
            return false;
        }

        $videoLength = strtotime('1970-01-01 00:' . $obj['properties'][0]['text'] . ' UTC');

        return $videoLength >= $length;
    }

    public function validateTaggedPeople($obj, ...$peopleNames) {
        foreach ($peopleNames as $personName) {
            if ($this->validateTaggedPerson($obj, $personName)) {
                return true;
            }
        }
    }

    public function validateTaggedPeopleAmount($obj, $amount) {
        return $obj->has('with_tags') && count($obj['with_tags']) >= $amount;
    }
}
