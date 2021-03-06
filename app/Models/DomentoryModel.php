<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DomentoryModel extends Model {

    use LogsActivity;

    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dormitory';
    protected static $logAttributes = ['name', 'user'];
    protected $primaryKey = "id";
    protected $guarded = ['id'];

}
