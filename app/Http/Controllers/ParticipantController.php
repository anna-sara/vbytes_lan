<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Volunteer;
use App\Models\Version;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ability = $request->ability;

        if ($ability === "key_1") {
           
            $participants =  Participant::all()->makeHidden(['comment', 'emailed', 'paid', 'member', 'gdpr']);
            $volunteers = Volunteer::all()->makeHidden(['gdpr']);

            $dataArr = [
                'participant' => $participants,
                'volunteer'  => $volunteers
            ];

            return $dataArr;
        }

        if ($ability === "key_2") {
           
            $participants =  Participant::all()->select('participant_id', 'first_name', 'surname');
            $volunteers = Volunteer::all()->select('first_name', 'surname');

            $dataArr = [
                'participant' => $participants,
                'volunteer'  => $volunteers
            ];

            return $dataArr;
        }

        if ($ability === "key_3") {
           
            $participants =  Participant::all()->makeHidden(['comment', 'emailed', 'paid', 'member', 'gdpr']);
           
            return $participants;
        }

        if ($ability === "key_4") {
           
            $participants =  Participant::all()->select('participant_id', 'first_name', 'surname');
           
            return $participants;
        }

        return false;
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
    public function store(Request $request)
    {
        $ability = $request->ability;

        if ($ability === "key_1") {
           

            $request->validate([
                'member' => 'required',
                'first_name' => 'required',
                'surname' => 'required',
                'grade' => 'required',
                'phone' => 'nullable',
                'email' => 'nullable',
                'guardian_name' => 'required',
                'guardian_phone' => 'required',
                'guardian_email' => 'required',
                'visiting' => 'required',
                'gdpr' => 'required',
                'friends' => 'nullable',
                'special_diet' => 'nullable',
            ]);

            $count = Participant::where('visiting', 0)->count();
            $status = "";

            if ($count < 2 && $request->visiting === 0) {
                $status = "lan";
            }

            else if ($request->visiting === 1) {
                $status = "besök";
            }

            else {
                $status = "reserv";
            }

            Participant::create([
                'member' => $request->member,
                'first_name' => $request->first_name,
                'surname' => $request->surname,
                'grade' => $request->grade,
                'phone' => $request->phone,
                'email' => $request->email,
                'guardian_name' => $request->guardian_name,
                'guardian_phone' => $request->guardian_phone,
                'guardian_email' => $request->guardian_email,
                'visiting' => $request->visiting,
                'gdpr' => $request->gdpr,
                'friends' => $request->friends,
                'special_diet' => $request->special_diet,
                'status' => $status
            ]);


            return response()->json([
                'success' => true, 'message' => 'Participant was created successfully'
            ]);
           
        }

        return response()->json([
                'success' => false, 'message' => 'Unauthorized'
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        //
    }
}


