<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiveChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //$user = Auth::guard('admin')->user();
        $user = Auth::user();
        $message = $request->message();

//        DB::table('chat_messages')->insert([]);
        event(new ChatEvent($user->name, $message));

        return response()->json([
            'status' => 'message sent.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::guard('web')->user();
        $liveId = $request->get('live_id');
        $userId = $request->get('user_id');
        $sender = $request->get('username');
        $message = $request->get('message');

        // Broadcasting to others
        broadcast(new ChatEvent($user, $message))->toOthers();

        // Insert to Database
        DB::table('chat_messages')->insert([
            'live_id' => $liveId,
            'user_id' => $userId,
            'sender' => $sender,
            'message' => $message,
            'created_at' => Carbon::now()
        ]);

        return response(['status' => 'Message '.$message.' sent!']);
    }

    public function getMessages(Request $request)
    {
        $liveId = $request->get('live_id');
        $messages = ChatMessage::where('live_id', $liveId)->get();

        return response()->json($messages);
    }
}
