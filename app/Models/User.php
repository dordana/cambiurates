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
}
