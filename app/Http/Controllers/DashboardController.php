<?php

namespace App\Http\Controllers;

use App\Models\Live;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if ($this->user->type !== 1) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('dashboard.home');

    }

    public function live(Request $request, $live_id)
    {
        $live = Live::find($live_id);

        return view('dashboard.live.live', [
            'type' => 'broadcaster',
            'id' => Auth::id(),
            'live' => $live
        ]);
    }

    public function create(Request $request)
    {
        return view('dashboard.live.create');
    }

    public function store(Request $request)
    {
        $now = Carbon::now();
        $user = $request->user();
        $live = new Live();
        $live->title = $request->title;
        $live->description = $request->description;
        $live->created_by = $user->id;
        $live->save();

        return redirect()->route('live.streaming', $live->id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function liveStarted(Request $request)
    {
        $live_id = $request->get('live_id');
        $datetime = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('live')
            ->where('id', $live_id)
            ->update(['started_at' => $datetime]);

        return response()->json([
            'status' => 'live updated.'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function liveEnded(Request $request)
    {
        $live_id = $request->get('live_id');
        $datetime = Carbon::now()->format('Y-m-d H:i:s');

        DB::table('live')
            ->where('id', $live_id)
            ->update(['ended_at' => $datetime]);

        return response()->json([
            'status' => 'live updated.'
        ]);
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
