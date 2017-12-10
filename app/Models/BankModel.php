<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BankModel extends Model
{
     use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banks';
      protected static $logAttributes = ['accountno', 'bname'];
    protected $primaryKey="id";
     protected $guarded = ['id'];  public $timestamps = false;
}
