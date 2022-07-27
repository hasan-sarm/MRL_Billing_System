<?php

namespace App\Console\Commands;

use App\Events\SendNotificationEvent;
use App\Models\Sub;
use App\Models\User;
use App\Notifications\RealTimeMassegeNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBrodcastUnpayed5days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert5:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'alert befor 5 days of next payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $day = Carbon::today()->addDays(5);
        $Subs=Sub::whereHas('user',
        function ($q) use ($day) {
             $q->where('category_id','2');
             $q->where('next_payment',$day);
             })->get();
        foreach ($Subs as $Sub)
        {
            $user_id = $Sub->user_id;
            $user=User::find($user_id);
            $email = $user->email;
            $data = [
                'id'=>$user_id,
                'email'=>$email,
                'massege'=>'you still have 5 days in '.$Sub->sub_name.' subscripe '
            ];
            $user->notify(new RealTimeMassegeNotification('Hi '.$user->name.' you still have 5 days in '.$Sub->sub_name.' subscripe '));
            event(new SendNotificationEvent($data));

        }
    }
}
