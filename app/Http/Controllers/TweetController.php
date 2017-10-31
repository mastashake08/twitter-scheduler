<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Jobs\ProcessTweet;
class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Tweet::all());
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create the tweet
        $tweet = Tweet::Create([
          'content' => $request->content,
          'publish_timestamp' => \Carbon\Carbon::parse($request->publish_timestamp)
        ]);

        //Add tweet to the queue
        ProcessTweet::dispatch($tweet)->delay(\Carbon\Carbon::parse($request->publish_timestamp,'America/New_York')->diffInSeconds(\Carbon\Carbon::now('America/New_York')));

        //return json
        return response()->json($tweet);
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
        return response()->json(Tweet::findOrFail($id));
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
        $tweet = Tweet::findOrFail($id);
        $tweet->fill([
          'content' => $request->content,
          'publish_timestamp' => \Carbon\Carbon::parse($request->publish_timestamp)
        ]);
        //return json
        return response()->json($tweet);
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
        Tweet::destroy($id);
    }
}
