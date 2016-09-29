<?php

namespace Scientist\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int                                                      $id
 * @property int                                                      $experiment_id
 * @property bool                                                     $control
 * @property mixed                                                    $value
 * @property float                                                    $start_time
 * @property float                                                    $end_time
 * @property float                                                    $start_memory
 * @property float                                                    $end_memory
 * @property \Exception|null                                          $exception
 * @property bool                                                     $match
 * @property \Carbon\Carbon                                           $created_at
 * @property \Carbon\Carbon                                           $updated_at
 *
 * @property-read float                                               $time
 * @property-read float                                               $memory
 * @property-read \Illuminate\Database\Eloquent\Collection|Experiment $experiment
 *
 * @mixin Model
 */
class Result extends Model
{
    protected $guarded = [];

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }

    public function getValueAttribute()
    {
        return unserialize($this->value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = serialize($value);
    }

    public function getExceptionAttribute()
    {
        return unserialize($this->exception);
    }

    public function setExceptionAttribute($value)
    {
        $this->attributes['exception'] = serialize($value);
    }

    public function getTimeAttribute()
    {
        return $this->end_time - $this->start_time;
    }

    public function getMemoryAttribute()
    {
        return $this->end_memory - $this->start_memory;
    }
}
