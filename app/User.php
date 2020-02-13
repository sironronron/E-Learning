<?php

namespace App;

use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'biography', 'facebook_link', 'twitter_link', 'youtube_link', 'role_id', 'birthday', 'phone', 'introduction', 'last_login_at', 'last_login_ip'
    ];

    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
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
        'photo_url',
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return array
     */
    public function courses()
    {
        return $this->hasMany('App\Models\Course\Course', 'teacher_id');
    }

    /**
     * @return array
     */
    public function userInstructorQuestion() {
        return $this->hasOne('App\Models\User\UserInstructorQuestion', 'user_id');
    }

    /**
     * @return array
     */
    public function instructorQuestions()
    {
        return $this->belongsTo('App\Models\User\UserInstructorQuestion', 'user_id');
    }

    /**
     * @return array
     */
    public function cart()
    {
        return $this->hasOne('App\Models\Cart\Cart', 'user_id');
    }

    /**
     * @return array
     */
    public function searches()
    {
        return $this->hasMany('App\Models\User\UserSearch', 'user_id');
    }

    /**
     * @return array
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Course\CourseRating');
    }

    /**
     * @return array
     */
    public function qnas()
    {
        return $this->hasMany('App\Models\Course\CourseQANDA');
    }

    /**
     * @return array
     */
    public function announcement()
    {
        return $this->hasMany('App\Models\Course\CourseAnnouncement');
    }

    /**
     * Return Lessons
     *
     * @return array
     */
    public function lesson()
    {
        return $this->hasMany('App\Models\Course\CourseUserProgress');
    }

    public function myReviews()
    {
        return $this->hasMany('App\Models\Course\CourseRating', 'teach_id')
            ->where('comments', '!=', null);
    }

}
