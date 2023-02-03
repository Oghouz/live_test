<?php

namespace App\Http\Controllers;

use App\Models\Live;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function playback(Request $request)
    {
        $lives = Live::all();

        return view('dashboard.live.playback', [
            'lives' => $lives
        ]);
    }

    public static function calcTimeDiff($started, $ended)
    {
        $started_at = Carbon::parse($started);
        $ended_at = Carbon::parse($ended);

        $totalSeconds = $started_at->diffInSeconds($ended_at);
        $second = $totalSeconds%60;
        $minute = intval($totalSeconds/60);
        $hors = intval($totalSeconds/360);
        if ($minute < 9) {
            $minute = '0'.$minute;
        }

        return "00 : " . $minute . " : " . $second;
    }

    public function videoStreaming(Request $request)
    {
        $live = Live::find(11);

        return view('dashboard.live.videoStreaming', [
                'type' => 'broadcaster',
                'id' => Auth::id(),
                'live' => $live
            ]);
    }

    public function statistic(Request $request)
    {
        return view('dashboard.statistic');
    }

    public function calendar(Request $request)
    {
        return view('dashboard.calendar');
    }

    public function users()
    {
        return view('dashboard.users');
    }
}
