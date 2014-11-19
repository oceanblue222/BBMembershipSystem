<?php

use Carbon\Carbon;
use Laracasts\Presenter\PresentableTrait;

class Proposal extends Eloquent {

    use PresentableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proposals';

    protected $presenter = 'BB\Presenters\ProposalPresenter';

    public function getDates()
    {
        return array('created_at', 'updated_at', 'end_date', 'start_date');
    }

    protected $fillable = [
        'title', 'description', 'end_date', 'user_id', 'start_date'
    ];

    public function votes()
    {
        return $this->hasMany('ProposalVote');
    }

    public function isOpen()
    {
        return $this->hasStarted() && !$this->hasFinished();
    }

    public function hasStarted()
    {
        return Carbon::now()->setTime(0, 0, 0)->gte($this->start_date);
    }

    public function hasFinished()
    {
        return Carbon::now()->subDay()->gt($this->end_date);
        //return $this->end_date->gt(Carbon::now()->subDay());
    }

} 