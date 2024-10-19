<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Jetstream\Jetstream;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'handling',
        'phone_no',
        'nick',
        'current_team_id',
        'status',
        'reff_team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The user own this data.
     *
     * @var array
     */
    public function clients($m = null, $y = null)
    {
        if ($m && $y) {
            return $this->hasMany('App\Models\Client', 'user_id')->whereMonth('created_at', '<=', $m)->whereYear('created_at', '<=', $y);
        }
        return $this->hasMany('App\Models\Client', 'user_id');
    }
    /**
     * inbounds
     *
     * @param  mixed $m
     * @param  mixed $y
     * @return void
     */
    public function inbounds($m = null, $y = null)
    {
        if ($m && $y) {
            return $this->hasMany('App\Models\Request', 'user_id')->whereNotNull('sent_at')->whereMonth('created_at', $m)->whereYear('created_at', $y);
        }
        return $this->hasMany('App\Models\Request', 'user_id')->whereNotNull('sent_at');
    }
    /**
     * outbounds
     *
     * @param  mixed $m
     * @param  mixed $y
     * @return void
     */
    public function outbounds($m = null, $y = null)
    {
        if ($m && $y) {
            return $this->hasMany('App\Models\Request', 'user_id')->whereNull('sent_at')->whereMonth('created_at', $m)->whereYear('created_at', $y);
        }
        return $this->hasMany('App\Models\Request', 'user_id')->whereNull('sent_at');
    }
    /**
     * sentsms
     *
     * @param  mixed $m
     * @param  mixed $y
     * @param  mixed $status
     * @return void
     */
    public function sentsms($m = null, $y = null, $status = null)
    {
        if ($status == 'total') {
            $result = $this->hasMany('App\Models\BlastMessage', 'user_id');
        } elseif ($status == 'UNDELIVERED') {
            $result = $this->hasMany('App\Models\BlastMessage', 'user_id')->whereIn('status', ['UNDELIVERED', 'PROCESSED']);
        } else {
            $result = $this->hasMany('App\Models\BlastMessage', 'user_id')->whereIn('status', ['DELIVERED', 'ACCEPTED']);
        }

        if ($m && $y) {
            $result = $result->whereMonth('created_at', $m)->whereYear('created_at', $y);
        }
        return $result;
    }

    /**
     * User has one Chat Session
     *
     * @return mixed
     */
    public function chatsession()
    {
        return $this->hasOne('App\Models\HandlingSession', 'agent_id');
    }

    /**
     * User Has many Team
     *
     * @return mixed
     */
    public function super()
    {
        return $this->hasMany('App\Models\TeamUser', 'user_id')->where('team_id', env('IN_HOUSE_TEAM_ID', 1));
    }

    /**
     * isNoAdmin
     *
     * @return void
     */
    public function isNoAdmin()
    {
        return $this->hasOne('App\Models\TeamUser', 'user_id')->where('team_id', '!=', env('IN_HOUSE_TEAM_ID', 1));
    }


    /**
     * User is Superuser
     *
     * @return mixed
     */
    public function isSuper()
    {
        return $this->hasOne('App\Models\TeamUser', 'user_id')->where('team_id', env('IN_HOUSE_TEAM_ID'));
    }


    /**
     * scopeNoadmin
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeNoadmin($query)
    {
        return $query->where('current_team_id', '!=', env('IN_HOUSE_TEAM_ID'))->orWhere('current_team_id', NULL);
    }

    /**
     * teams
     *
     * @return mixed
     */
    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'user_id');
    }

    /**
     * list teams
     *
     * @return mixed
     */
    public function listTeams()
    {
        return $this->hasMany('App\Models\TeamUser', 'user_id');
    }
    /**
     * team
     *
     * @return void
     */
    public function team()
    {
        return $this->belongsTo('App\Models\TeamUser', 'current_team_id', 'team_id')->where('user_id', $this->id);
    }

    /**
     * billings
     *
     * @return mixed
     */
    public function billings()
    {
        return $this->hasMany('App\Models\Billing', 'user_id');
    }

    /**
     * User Has many Role
     *
     * @return mixed
     */
    public function role()
    {
        return $this->hasMany('App\Models\RoleUser', 'user_id');
    }
    /**
     * listRole
     *
     * @return void
     */
    public function listRole()
    {
        return $this->hasMany('App\Models\RoleUser', 'user_id');
    }

    /**
     * User get active Role
     *
     * @return mixed
     */
    public function activeRoles()
    {
        return $this->hasOne('App\Models\RoleUser', 'user_id');
    }
    /**
     * activeRole
     *
     * @return void
     */
    public function activeRole()
    {
        return $this->hasOne('App\Models\RoleUser', 'user_id')->orderBy('active', 'desc');
        ;
    }

    /**
     * User Has many Balance
     *
     * @return mixed
     */
    public function balance($team_id = 0)
    {
        if ($team_id > 0) {
            return $this->hasMany('App\Models\SaldoUser', 'user_id')->where('team_id', $team_id)->orderBy('id', 'desc');
        }
        return $this->hasMany('App\Models\SaldoUser', 'user_id')->orderBy('id', 'desc');
    }

    /**
     * balanceTeam
     *
     * @return mixed
     */
    public function balanceTeam()
    {
        return $this->hasMany('App\Models\SaldoUser', 'user_id')->orderBy('created_at', 'desc');
    }

    /**
     * User is client
     *
     * @return mixed
     */
    public function isClient()
    {
        return $this->hasOne('App\Models\Client', 'email', 'email')->where('user_id', 0);
    }

    /**
     * User has one profile billing
     *
     * @return mixed
     */
    public function userBilling()
    {
        return $this->hasOne('App\Models\BillingUser', 'user_id');
    }

    /**
     * photo
     *
     * @return mixed
     */
    public function photo()
    {
        return $this->hasOne('App\Models\Attachment', 'model_id')->where('model', 'user');
    }

    /**
     * getProfilePhotoUrlAttribute
     *
     * @return mixed
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->photo)
            return 'https://telixcel.s3.ap-southeast-1.amazonaws.com/' . $this->photo->file;
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Has Companies
     *
     * @return mixed
     */
    public function company()
    {
        return $this->hasOne('App\Models\Company', 'user_id');
    }

    /**
     * Many API Credential
     *
     * @return mixed
     */
    public function credential()
    {
        return $this->hasMany('App\Models\ApiCredential', 'user_id');
    }

    /**
     * providerUser
     *
     * @return void
     */
    public function providerUser()
    {
        return $this->hasMany('App\Models\ProviderUser', 'user_id');
    }

    /**
     * browserSessionUser
     *
     * @return void
     */
    public function browserSessionUser()
    {
        return $this->hasMany('App\Models\BrowserSession', 'user_id');
    }

    /**
     * department
     *
     * @return void
     */
    public function department()
    {
        return $this->hasMany('App\Models\Department', 'user_id');
    }


    public function clientValidations()
    {
        return $this->hasMany('App\Models\ClientValidation', 'user_id');
    }
    //=============
    //FROM TRAIT
    //=============

    /**
     * Get the current team of the user's context.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        return $this->belongsTo(Jetstream::teamModel(), 'current_team_id');
    }

    /**
     * Switch the user's context to the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function switchTeam($team)
    {
        if (!$this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);

        return true;
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        if (is_null($team)) {
            return false;
        }

        return $this->id == $team->{$this->getForeignKey()};
    }

    /**
     * Determine if the user belongs to the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function belongsToTeam($team)
    {
        if (is_null($team)) {
            return false;
        }
        $user = auth()->user()->id;
        return $this->ownsTeam($team) || $this->teams->contains(function ($t) use ($team) {
            return $t->id === $team->id;
        }) || $team->users->pluck('id')->contains(function ($u) use ($user) {
            return $u === $user;
        });
    }
}
