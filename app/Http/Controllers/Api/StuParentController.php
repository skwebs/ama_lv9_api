<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\StuParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StuParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StuParent::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $validator = Validator::make(
            $request->all(),
            [
                "father_name" => "required|min:3|max:30|regex:/[a-zA-Z\s]/",
                "father_email" => "nullable|email",
                "father_contact" => "required|numeric|digits:10|starts_with:9,8,7,6",
                "father_contact_2" => "nullable|numeric|digits:10|starts_with:9,8,7,6",
                "father_whatsapp" => "nullable|numeric|digits:10|starts_with:9,8,7,6",
                "father_qualification" => "required",
                "father_occupation" => "required",
                "father_annual_income" => "required|numeric",

                "mother_name" => "required|min:3",
                "mother_email" => "nullable|email",
                "mother_contact" => "nullable|numeric|digits:10|starts_with:9,8,7,6",
                "mother_contact_2" => "nullable|numeric|digits:10|starts_with:9,8,7,6",
                "mother_whatsapp" => "nullable|numeric|digits:10|starts_with:9,8,7,6",
                "mother_qualification" => "required",
                "mother_occupation" => "required",
                "mother_annual_income" => "nullable|numeric",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation error",
                "error" => $validator->errors()
            ]);
        }

        $request->mergeIfMissing(['created_by' => 2]);

        $res = StuParent::create($request->only([
            'father_name',
            'father_email',
            'father_contact',
            'father_contact_2',
            'father_whatsapp',
            'father_qualification',
            'father_occupation',
            'father_annual_income',

            'mother_name',
            'mother_email',
            'mother_contact',
            'mother_contact_2',
            'mother_whatsapp',
            'mother_qualification',
            'mother_occupation',
            'mother_annual_income',

            'created_by'
        ]));


        // $request->mergeIfMissing(['created_by' => auth()->user()->name]);

        if ($res) {
            return response()->json([
                "status" => "success",
                "message" => "Record created successfully!",
                "data" => $res
            ]);
        }

        return response()->json([
            "status" => "failed",
            "message" => "Record couldn't create!",
            "data" => null
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
}

    