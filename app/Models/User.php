<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
	    'nearest_station',
        'email',
        'password',
        'remember_token',
        'cambiu_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    

    /**
     * @param $password
     * @return self
     */
    public function sendRegistationEmail($password = '')
    {

        try {
            $me = $this;
            $emailContent = '';
            $emailContent .= "Username : ". $this->email.'</br>';
            $emailContent .= "Password : ". $password;

            Mail::send([], [], function ($message) use ($emailContent, $me) {

                $from = config('mail.from');
                $message->from($from['address'], $from['name']);
                $message->to($me->email, $me->email)
                    ->subject('Cambiu Rates Registration.')
                    ->setBody($emailContent, 'text/html');
            });
        } catch (\Exception $e) {
            Log::error($e->getFile() . ' | ' . $e->getLine() . ' | ' . $e->getMessage());
        }
    }
    

    /**
     * @return $this
     */
    public function exchangeRates(){

        return $this->belongsToMany(ExchangeRate::class, 'user_exchange_rates', 'user_id', 'exchange_rate_id')->withPivot(['visible','sell','buy'])->orderBy('user_exchange_rates.id', 'asc');;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userExchangeRates(){

        return $this->hasMany(UserExchangeRate::class);
    }
}