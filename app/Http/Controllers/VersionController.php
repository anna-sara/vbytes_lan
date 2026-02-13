<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $permission = $request->permission;

        if ($permission === "key_5") {
            
            $latest_version_participants = Version::where('table', 'participants')->latest()->first();
            $latest_version_volunteers = Version::where('table', 'volunteers')->latest()->first();

            return response()->json([
                'code' => 200, 'participants' => $latest_version_participants ? $latest_version_participants->version : null , 'volunteers' => $latest_version_volunteers ? $latest_version_volunteers->version :  null
            ]);
           
        }

         if ($permission === "key_2") {
           
            $latest_version_participants = Version::where('table', 'participants')->latest()->first();
            $latest_version_volunteers = Version::where('table', 'volunteers')->latest()->first();

            return response()->json([
                'code' => 200, 'participants' => $latest_version_participants ? $latest_version_participants->version : null , 'volunteers' => $latest_version_volunteers ? $latest_version_volunteers->version :  null
            ]);

        }

         if ($permission === "key_3") {
           
            $latest_version_participants = Version::where('table', 'participants')->latest()->first();
    

            return response()->json([
                'code' => 200, 'participants' => $latest_version_participants ? $latest_version_participants->version : null 
            ]);
           
        }

         if ($permission === "key_4") {
           

            $latest_version_participants = Version::where('table', 'participants')->latest()->first();
    

            return response()->json([
                'code' => 200, 'participants' => $latest_version_participants ? $latest_version_participants->version : null 
            ]);
           
        }

        return response()->json([
                'code' => 401, 'message' => 'Unauthorized'
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Version $version)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Version $version)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Version $version)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Version $version)
    {
        //
    }
}
