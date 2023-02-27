<?php

namespace App\Http\Controllers;

use App\Events\LiveStartEvent;
use App\Events\StreamAnswer;
use App\Events\StreamOffer;
use App\Models\Live;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\FingersCrossed\ActivationStrategyInterface;

class WebrtcStreamingController extends Controller
{

    public function index()
    {
        //  The view for the broadcaster.
        return view('video-broadcast', ['type' => 'broadcaster', 'id' => Auth::id()]);
    }

//    public function startLive($token)
//    {
//        if ($token && $token="abcdefg123456") {
//            $user = Auth::loginUsingId(1);
//            return view('live', ['type' => 'broadcaster', 'id' => 1]);
//
//        }
//
//        return abort(404);
//
//    }

    public function consumer(Request $request, $streamId, $token)
    {
        // The view for the consumer(viewer). They join with a link that bears the streamId
        // initiated by a specific broadcaster.
        $user = Auth::user();
        $live = Live::find($streamId);
        if (!$live || $live->token !== $token) {
            return abort(403);
        }

        if ($live->onLive) {

            return view('viewer', ['type' => 'consumer', 'streamId' => $streamId, 'id' => Auth::id(), 'user' => $user, 'live' => $live]);
        }

        //return view('loadingLive', ['live' => $live]);
        return view('waitLive', ['live' => $live]);

    }

    public function loadingLive()
    {
        return view('loadingLive');
    }

    public function makeStreamOffer(Request $request)
    {
        // Broadcasts an offer signal sent by broadcaster to a specific user who just joined
        $data['broadcaster'] = $request->broadcaster;
        $data['receiver'] = $request->receiver;
        $data['offer'] = $request->offer;

        event(new StreamOffer($data));
    }

    public function makeStreamAnswer(Request $request)
    {
        // Sends an answer signal to broadcaster to fully establish the peer connection.
        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
    }

    public function liveNotify(Request $request)
    {
        event(new LiveStartEvent(1));

        return response()->json([
            'message' => 'live notify success'
        ]);
    }
}
