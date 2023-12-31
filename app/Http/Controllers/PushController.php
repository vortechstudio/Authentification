<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\System\SendMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;

/**
 * @codeCoverageIgnore
 */
class PushController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }

    public function push()
    {
        Notification::send(User::all(), new SendMessageNotification('Test', 'lorem', 'info'));

        return redirect()->back();
    }
}
