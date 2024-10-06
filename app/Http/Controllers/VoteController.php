<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use App\Models\Forecast;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Forecast $forecast, $vote)
    {
        $isUpvote = $vote === 'upvote';

        $user = auth()->user();

        Vote::updateOrCreate(
            ['user_id' => $user->id, 'forecast_id' => $forecast->id],
            ['is_upvote' => $isUpvote]
        );

        return back()->with('response', [
            'success' => true,
            'message' => "Berhasil melakukan vote"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
