<?php

namespace Scientist\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int                                                    $id
 * @property string                                                 $name
 * @property callable                                               $control
 * @property callable[]                                             $trials
 * @property mixed[]                                                $params
 * @property int                                                    $chance
 * @property \Carbon\Carbon                                         $created_at
 * @property \Carbon\Carbon                                         $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Result[] $results
 *
 * @mixin Model
 */
class Experiment extends Model
{
    protected $guarded = [];

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getControlAttribute()
    {
        return unserialize($this->control);
    }

    public function setControlAttribute($value)
    {
        $this->attributes['control'] = serialize($value);
    }

    public function getTrialsAttribute()
    {
        return unserialize($this->trials);
    }

    public function setTrialsAttribute($value)
    {
        $this->attributes['trials'] = serialize($value);
    }

    public function getParamsAttribute()
    {
        return unserialize($this->params);
    }

    public function setParamsAttribute($value)
    {
        $this->attributes['params'] = serialize($value);
    }
}
