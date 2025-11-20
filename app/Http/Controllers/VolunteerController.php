<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;

class VolunteerController extends Controller
{
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = $request->permission;

        if ($permission === "key_1") {
           

            $request->validate([
                'first_name' => 'required',
                'surname' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'gdpr' => 'required',
                'areas' => 'required',
            ]);


            Volunteer::create([
                'first_name' => $request->first_name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
                'gdpr' => $request->gdpr,
                'areas' => $request->areas,
            ]);


            return response()->json([
                'code' => 200, 'message' => 'Volunteer was created successfully'
            ]);
           
        }

        return response()->json([
                'code' => 401, 'message' => 'Unauthorized'
        ]);
        
    }
}
