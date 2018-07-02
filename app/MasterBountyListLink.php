<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBountyListLink extends Model
{
    protected $table = 'master_bounty_list_links';
    protected $fillable = array('bounty_list_id', 'link_id', 'bounty_list_link');
}
