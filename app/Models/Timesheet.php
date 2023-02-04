<?php

namespace App\Models;

use App\Http\Resources\TimesheetsIndexResourceCollection;
use Carbon\Carbon;
use Dyrynda\Database\Support\CascadeSoftDeletes;
// use Iatstuti\Database\Support\CascadeSoftDeletes;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Wildside\Userstamps\Userstamps;

class Timesheet extends Model
{
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Userstamps;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'week_no' => [
            'searchable' => false,
        ],
        'week_end_date' => [
            'searchable' => true,
            'orderable' => true,
        ],
        // 'formatted_week_end_date' => [
        //     'searchable' => true,
        //     'orderable' => true,
        // ],
        'start_datetime' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'start_date' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'pay_date' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'hours' => [
            'searchable' => true,
            'orderable' => true,
        ],
        'total_amount' => [
            'searchable' => true,
            'orderable' => true,
        ],

    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            "job" => [
                "model" => Job::class,
                "foreign_key" => "job_id",
                "columns" => [
                    "JobName" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],
            "employee" => [
                "model" => Employee::class,
                "foreign_key" => "employee_id",
                "columns" => [
                    "full_name" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],

        ],

    ];

    protected $cascadeDeletes = ['expenses'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'team';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timesheets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    // protected $fillable = ['time_interval', 'week_no', 'week_end_date', 'start_date', 'end_date', 'start_datetime', 'end_datetime', 'break', 'hours', 'hourly_rate', 'daily_rate', 'weekly_rate', 'sub_rate', 'pay_amount', 'expenses', 'total_amount', 'memo', 'extras', 'employee_id', 'job_id', 'costcode_id', 'account_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'extras' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['week_end_date', 'start_date', 'end_date', 'start_datetime', 'end_datetime', 'created_at', 'updated_at', 'deleted_at', 'paid_at', 'paid_at_copy'];

    protected $appends = [
        'formatted_week_end_date',
        'formatted_week_no',
        'formatted_pay_date',
        'day',
        'rate',
    ];

    protected static function booted()
    {
        static::saving(function ($timesheet) {
            $hours = isset($timesheet->attributes['hours']) ? $timesheet->attributes['hours'] : 1;

            if (isset($timesheet->attributes['start_datetime'])) {
                $interval = 'daily';
                $weekNo = (Carbon::parse($timesheet->attributes['end_datetime']))->format('Y')
                    . '-'
                    . str_pad(
                        (Carbon::parse($timesheet->attributes['end_datetime']))
                            ->format('W'),
                        2,
                        STR_PAD_LEFT
                    );
                $weekEndDate = (Carbon::parse($timesheet->attributes['start_datetime']))
                    ->previous('Sunday')
                    ->addWeek()
                    ->format('Y-m-d');
                $payDay = (Carbon::parse($timesheet->attributes['start_datetime']))
                    ->startOfWeek()
                    ->addWeek()
                    ->next('Tuesday')
                    ->format('Y-m-d');
            } else {
                $interval = 'weekly';
                $weekNo = (Carbon::parse($timesheet->attributes['end_date']))->format('Y')
                    . '-'
                    . str_pad(
                        (Carbon::parse($timesheet->attributes['end_date']))
                            ->format('W'),
                        2,
                        STR_PAD_LEFT
                    );
                $weekEndDate = (Carbon::parse($timesheet->attributes['start_datetime']))
                    ->previous('Sunday')
                    ->addWeek()
                    ->format('Y-m-d');
                $payDay = (Carbon::parse($timesheet->attributes['start_datetime']))
                    ->startOfWeek()
                    ->addWeek()
                    ->next('Tuesday')
                    ->format('Y-m-d');
                if ($timesheet->employee->is_on_salary) {
                    $timesheet->total_amount = ((float) $timesheet->expenses_total + (float) $timesheet->employee->weekly_rate);
                }
            }

            $startDate = (Carbon::parse($timesheet->attributes['start_datetime']))
                ->format('Y-m-d');
            $endDate = (Carbon::parse($timesheet->attributes['start_datetime']))
                ->format('Y-m-d');

            if (isset($timesheet->employee->weekly_rate)) {
                $net = $timesheet->employee->weekly_rate / 5.5;
                $adjustment = isset($timesheet->attributes['adjustment_amount']) ? $timesheet->attributes['adjustment_amount'] : 0;
                $total_amount = $net + $adjustment;
                $timesheet->setAttribute('pay_amount', $net);
                $timesheet->setAttribute('total_amount', $total_amount);
                $timesheet->setAttribute('average', $net / $hours);
            } elseif (isset($timesheet->employee->daily_rate)) {
                $net = $timesheet->employee->daily_rate;
                $adjustment = isset($timesheet->attributes['adjustment_amount']) ? $timesheet->attributes['adjustment_amount'] : 0;
                $total_amount = $net + $adjustment;
                $timesheet->setAttribute('pay_amount', $net);
                $timesheet->setAttribute('total_amount', $total_amount);
                $timesheet->setAttribute('average', $net / $hours);
            }



            // $timesheet->setAttribute('time_interval', $interval);
            $timesheet->setAttribute('week_no', $weekNo);
            $timesheet->setAttribute('week_end_date', $weekEndDate);
            $timesheet->setAttribute('pay_date', $payDay);
            $timesheet->setAttribute('start_date', $startDate);
            $timesheet->setAttribute('end_date', $endDate);
        });

        static::creating(function ($timesheet) {
            $timesheet->setAttribute('record_no', Hash::make($timesheet->created_at));
        });
    }

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class, 'daily_log_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'timesheet_id', 'id')->with('account');
    }

    // public function getJobNameAttribute()
    // {
    //     return isset($this->job) ? $this->job->JobName : '';
    // }

    public function getPayDateAttribute($value)
    {
        if ($value != null) {
            return $value;
        } elseif ($this->start_datetime != null) {
            return $this->start_datetime->startOfWeek()
                ->addWeek()
                ->next('Tuesday')
                ->format('Y-m-d');
        } elseif ($this->start_date != null) {
            return $this->start_date->startOfWeek()
                ->addWeek()
                ->next('Tuesday')
                ->format('Y-m-d');
        }
    }

    public function getFormattedPayDateAttribute()
    {
        if (isset($this->pay_date) && $this->pay_date !== null) {
            $payDay = Carbon::parse($this->pay_date);

            return strtoupper($payDay->format('D')) . $payDay->format(', m/d/y');
        }
    }

    public function getFormattedWeekNoAttribute()
    {
        return $this->week_end_date->format('Y') . '-' . $this->week_no;
    }

    public function getFormattedWeekEndDateAttribute()
    {
        return $this->week_end_date->format('m-d-Y');
    }

    public function getDayAttribute()
    {
        if ($this->start_datetime != null) {
            return strtoupper($this->start_datetime->format('D')) . $this->start_datetime->format(', m/d/y');
        } elseif ($this->start_date != null) {
            return 'WEEK of ' . strtoupper($this->start_date->format('D')) . $this->start_date->format(', m/d/y');
        } else {
            return "No start date!";
        }
        // return $this->start_datetime?strtoupper($this->start_datetime->format('D')).$this->start_datetime->format(', m/d/y'):'WEEKLY, STARTS ON'. strtoupper($this->start_date->format('D')).$this->start_date->format(', m/d/y');
        // // return $this->start_datetime->format('D, m/d/y');
    }

    public function setTotalAmountAttribute($amount)
    {
        $this->attributes['total_amount'] = number_format((float) $amount, 2, '.', '');
    }

    public function setPayAmountAttribute($amount)
    {
        $this->attributes['pay_amount'] = number_format((float) $amount, 2, '.', '');
    }

    public function setAdjustmentAmountAttribute($amount)
    {
        $this->attributes['adjustment_amount'] = number_format((float) $amount, 2, '.', '');
    }

    public function setAverageAttribute($amount)
    {
        $this->attributes['average'] = number_format((float) $amount, 2, '.', '');
    }

    public function getAverageAttribute($amount)
    {
        return number_format((float) $amount, 2, '.', '');
    }

    public function getRateAttribute()
    {
        if (isset($this->weekly_rate)) {
            return number_format((float) ($this->weekly_rate / 5.5), 2, '.', '') ;
        }
        if (isset($this->daily_rate)) {
            return $this->daily_rate;
        }
        if (isset($this->hourly_rate)) {
            return $this->hourly_rate;
        }
    }

    public function getTotalAmountAttribute($amount)
    {
        return number_format((float) $amount, 2, '.', '');
    }

    public function getPayAmountAttribute($amount)
    {
        return number_format((float) $amount, 2, '.', '');
    }

    public function getAdjustmentAmountAttribute($amount)
    {
        return number_format((float) $amount, 2, '.', '');
    }

    public function costcode()
    {
        return $this->belongsTo(Costcode::class, 'costcode_id', 'id');
    }

    // public function payRate()
    // {
    //     return $this->belongsTo(PayRate::class, 'pay_rate_id', 'id');
    // }
    public function glMaster()
    {
        return $this->belongsTo(GlMaster::class, 'gl_master_id', 'id');
    }

    // public function salary()
    // {
    //     return $this->payRate->salary ?? false;
    // }

    public function payroll()
    {
        return $this->hasMany(Timesheet::class, 'week_end_date', 'week_end_date');
    }
}
