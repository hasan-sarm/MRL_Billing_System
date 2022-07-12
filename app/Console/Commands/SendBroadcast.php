<?php

namespace App\Console\Commands;

use App\Events\SendNotificationEvent;
use App\Models\Sub;
use App\Models\SuperAdmin;
use App\Models\User;
use App\Notifications\RealTimeMassegeNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcast a message';

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
        $today = Carbon::today();

        $Subs=Sub::whereHas('user',
        function ($q) use ( $today) {
             $q->where('next_payment',$today);
             })->get();
        foreach ($Subs as $Sub)
        {
            $user_id = $Sub->user_id;
            $user=User::find($user_id);
            $email = $user->email;
            $data = [
                'id'=>$user_id,
                'email'=>$email,
                'massege'=>'new '.$Sub->sub_name.' invoice shoud be issued '
            ];
            $user->notify(new RealTimeMassegeNotification('Hi '.$user->name.' new '.$Sub->sub_name.' invoice shoud be issued '));
            event(new SendNotificationEvent($data));

        }

    }
}
