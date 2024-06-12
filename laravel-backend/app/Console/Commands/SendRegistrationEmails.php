<?php

namespace App\Console\Commands;

use App\Mail\ConfirmationEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendRegistrationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-registration-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): string
    {
        $users = User::all();
        foreach ($users as $user){
            $referralCode = Str::uuid();
            $user->update([
               'email_verified_at' => null,
               'referral_code' => $referralCode,
            ]);
            $user->save();
            Mail::to($user->email)->send(new ConfirmationEmail($referralCode));
        }
        return "Successfully resend all registration emails";
    }
}
