<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BountyListLink extends Model
{
   	protected $table = 'bounty_list_links';
    protected $fillable = array('bounty_list_id', 'bounty_list_link','type_link');
}
