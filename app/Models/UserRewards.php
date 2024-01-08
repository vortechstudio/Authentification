<?php

namespace App\Models;

use App\Notifications\System\SendMessageNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRewards extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userService()
    {
        return $this->belongsTo(UserService::class, 'user_service_id');
    }

    public static function sendReward($reward_type, $quantity, $user_service_id)
    {
        $reward = self::create([
            'reward_type' => $reward_type,
            'quantity' => $quantity,
            'user_service_id' => $user_service_id,
        ]);

        $reward->user->notify(new SendMessageNotification(
            'Vous avez reçu une récompense',
            "Vous avez reçu une récompense de la part de l'administrateur du service ".$reward->userService->service->name.'.',
            'success',
            'fa-gift',
        ));

    }
}
