<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;

class UserActivities extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'user_activities';

    protected $fillable = [
        'user_id', 'activity'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Add Activity
     * 
     * @return void
     * 
     * @access public
     */
    public function addActivity($userid, $activity, $isnotification = 1)
    {
        //insert
        $activityObj = new UserActivities;
        $activityObj->user_id = $userid;
        $activityObj->activity = $activity;
        $activityObj->visible = 1;
        $activityObj->is_notification = $isnotification;
        $activityObj->save();
    }

    /**
     * Get Activities
     * 
     * @return array
     * 
     * @access public
     */
    public function getActivities()
    {
        $acitivityList = DB::table('user_activities')
            ->join('users', 'user_activities.user_id', '=', 'users.id')
            ->select('user_activities.*', 'users.name', 'users.email')
            ->orderBy('user_activities.created_at', 'desc')
            ->paginate(15);

        return $acitivityList;
    }

    /**
     * Get Notify Activities
     * 
     * @return array
     * 
     * @access public
     */
    public function getNotifyActivities()
    {
        $acitivityList = DB::table('user_activities')
            ->join('users', 'user_activities.user_id', '=', 'users.id')
            ->select('user_activities.*', 'users.name', 'users.email')
            ->where('user_activities.is_notification', '=', 1)
            ->orderBy('user_activities.created_at', 'desc')
            ->paginate(15);

        return $acitivityList;
    }

    /**
     * Get Human Readable Time
     * 
     * @param string $time
     * 
     * @return string
     * 
     * @access public
     */
    public static function getHumanTime($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }

}
