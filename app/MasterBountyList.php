<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBountyList extends Model
{
    protected $table = 'master_bounty_lists';
    protected $fillable = array('bounty_uid', 'bounty_username');
}
