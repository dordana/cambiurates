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
        'name', 'email', 'password','confirmation_code', 'confirmed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = ['confirmed' => 'integer'];

    /**
     * @return self
     */
    public function deliverConfirmationCode()
    {

        $this->generateConfirmationCode();
        $this->sendConfirmationCodeEmail();
    }

    /**
     * @return self
     */
    private function sendConfirmationCodeEmail()
    {

        try {
            $me = $this;
            $emailContent = '';
            $emailContent .= "Your confirmation code is: " . $me->confirmation_code . "<br />";

            Mail::send([], [], function ($message) use ($emailContent, $me) {

                $from = config('mail.from');
                $message->from($from['address'], $from['name']);
                $message->to($me->email, $me->email)
                    ->subject('Confirm your login attempt.')
                    ->setBody($emailContent, 'text/html');
            });
        } catch (\Exception $e) {
            Log::error($e->getFile() . ' | ' . $e->getLine() . ' | ' . $e->getMessage());
        }
    }

    /**
     * @return self
     */
    private function generateConfirmationCode()
    {

        $code = substr(bin2hex(random_bytes(72)), 0, 8);
        $me = $this;
        $me->confirmation_code = $code;
        $me->save();
    }

    /**
     * @return $this
     */
    public function exchangeRates(){

        return $this->exchange_rates();
    }

    public function exchange_rates(){

        return $this->belongsToMany(ExchangeRate::class, 'user_exchange_rates', 'user_id', 'exchange_rate_id')->withPivot(['visible'])->orderBy('user_exchange_rates.id', 'asc');;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userExchangeRates(){

        return $this->user_exchange_rates();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_exchange_rates()
    {
        return $this->hasMany(UserExchangeRate::class);
    }
}