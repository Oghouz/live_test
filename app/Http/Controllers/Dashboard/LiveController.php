<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Live;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LiveController extends Controller
{
    public function index()
    {
        return 'ROUTE INDEX';
    }
    public function live(Request $request, $live_id)
    {
        $user = Auth::guard('admin')->user();
        $live = Live::find($live_id);

        return view('dashboard.live.live', [
            'type' => 'broadcaster',
            'auth_user' => $user,
            'id' =>$user->id,
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
        $token = urlencode(Hash::make(uniqid()));

        dd($request->all());

        $live = new Live();
        $live->title = $request->title;
        $live->description = $request->description;
        $live->token = $token;
        $live->created_by = $user->id;
        $live->created_at = $now;
        $live->updated_at = $now;
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
            ->update([
                'started_at' => $datetime,
                'onLive' => true
            ]);

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
            ->update([
                'ended_at' => $datetime,
                'onLive' => false
            ]);

        return response()->json([
            'status' => 'live updated.'
        ]);
    }
}
