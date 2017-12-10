<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class BillModel extends Model
{
     use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'billmanager';
    protected static $logAttributes = ['type', 'amount','year','term','worker'];
    protected $primaryKey="ID";
    protected $guarded = ['ID'];
    public $timestamps = false;
   public function program(){
        return $this->belongsTo('App\Models\ClassModel', "classes","name");
    }
      public function staff(){
        return $this->belongsTo('App\Models\WorkerModel', "worker","emp_number");
      }
}
