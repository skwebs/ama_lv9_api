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
    public function index(Request $request)
    {
        $r = null;
        $stuParent = new StuParent();

        // check query used or not
        if (null !== $request->query() && $q = $request->query()) {

            // list of params
            $sortArr = ['id', 'father_name', 'mother_name'];
            $queryKeyArr = ['sort', 'order'];

            $sort_param_list = join(' or ', array_filter(array_merge(array(join(', ', array_slice($sortArr, 0, -1))), array_slice($sortArr, -1)), 'strlen'));
            $query_key_list = join(' or ', array_filter(array_merge(array(join(', ', array_slice($queryKeyArr, 0, -1))), array_slice($queryKeyArr, -1)), 'strlen'));


            if (count(array_intersect_key(array_flip($queryKeyArr), $q)) !== count($q)) {
                return response()->json([
                    "success" => false,
                    "message" => "QueryKey error",
                    "error" => "Query key must be $query_key_list."
                ]);
            }

            // if order parameter found
            if (isset($q['sort']) && !in_array($q['sort'], $sortArr)) {

                // if order pararameter is not valid
                return response()->json([
                    "success" => false,
                    "message" => "QueryParam error",
                    "error" => "Sort parameter must be $sort_param_list ."
                ]);
            }


            if (isset($q['order']) && !in_array(strtolower($q['order']), ['asc', 'desc'])) {

                // if order pararameter is not valid
                return response()->json([
                    "success" => false,
                    "message" => "QueryParam error",
                    "error" => 'Order parameter should be "asc" or "desc"'
                ]);
            }

            // if any parameter found
            if (isset($q['sort']) && isset($q['order'])) {
                // if both sort and order parameters found
                $r = $stuParent->orderBy($q['sort'], $q['order']);
            } else {
                if (isset($q['sort'])) {
                    // if sort parameter found
                    $r = $stuParent->orderBy($q['sort']);
                }
                if (isset($q['order'])) {
                    // if order parameter found
                    $r = $stuParent->orderBy('id', $q['order']);
                }
            }
        }

        if ($r !== null) {
            return response()->json([
                "success" => true,
                "status" => "FilteredDatafetched",
                "message" => "Filter Data fetched.",
                "data" => $r->get()
            ]);
        } else {
            return response()->json([
                "success" => true,
                "status" => "AllDatafetched",
                "message" => "All Data fetched.",
                "data" => $stuParent->get()
            ]);
        }
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

                "created_by" => "required|numeric"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "status" => "ValidationFailed",
                "message" => "Validation error",
                "error" => $validator->errors()
            ]);
        }

        // $request->mergeIfMissing(['created_by' => 2]);

        $res = StuParent::create($request->only([
            'father_name',
            'father_email',
            'father_contact',
            'father_contact_2',
            'father_whatsapp',
            'father_qualification',
            'father_occupation',
            'father_annual_income',
            'father_photo',

            'mother_name',
            'mother_email',
            'mother_contact',
            'mother_contact_2',
            'mother_whatsapp',
            'mother_qualification',
            'mother_occupation',
            'mother_annual_income',
            'mother_photo',

            'created_by'
        ]));


        // $request->mergeIfMissing(['created_by' => auth()->user()->name]);

        if ($res) {
            return response()->json([
                "success" => true,
                "status" => "success",
                "message" => "Record created successfully!",
                "data" => $res
            ]);
        }

        return response()->json([
            "success" => false,
            "status" => "failed",
            "message" => "Record couldn't create!",
            "error" => "Unknown"
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

        $stuParent = StuParent::whereId($id);
        if ($stuParent->exists()) {
            return response()->json([
                "success" => true,
                "status" => "success",
                "message" => "Fetched single data",
                "data" => $stuParent->first()
            ]);
        }
        return response()->json([
            "success" => false,
            "status" => "failed",
            "message" => "RecordNotExist",
            "error" => "Requested record doesn't exist."
        ]);
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
        $stuParent = StuParent::whereId($id);
        if (!$stuParent->exists()) {
            return response()->json([
                "success" => false,
                "status" => "failed",
                "message" => "RecordNotExist",
                "error" => "Requested record doesn't exist."
            ]);
        }

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

                "created_by" => "required|numeric"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "status" => "Validation failed",
                "message" => "Validation error",
                "error" => $validator->errors()
            ]);
        }

        // $request->mergeIfMissing(['created_by' => 2]);

        // $stuParent = StuParent::find($id);


        $res = $stuParent->first()->update($request->only([
            'father_name',
            'father_email',
            'father_contact',
            'father_contact_2',
            'father_whatsapp',
            'father_qualification',
            'father_occupation',
            'father_annual_income',
            'father_photo',

            'mother_name',
            'mother_email',
            'mother_contact',
            'mother_contact_2',
            'mother_whatsapp',
            'mother_qualification',
            'mother_occupation',
            'mother_annual_income',
            'mother_photo',

            'updated_by'
        ]));


        // $request->mergeIfMissing(['created_by' => auth()->user()->name]);

        if ($res) {
            return response()->json([
                "success" => true,
                "status" => "success",
                "message" => "Record updated successfully!",
                "data" => $request->all()
            ]);
        }

        return response()->json([
            "success" => false,
            "status" => "failed",
            "message" => "Record couldn't update!",
            "error" => "Unknown"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stuParent = StuParent::whereId($id);
        if (!$stuParent->exists()) {
            return response()->json([
                "success" => false,
                "status" => "failed",
                "message" => "RecordNotExist",
                "error" => "Requested record doesn't exist."
            ]);
        }

        $res = $stuParent->first()->delete();

        if ($res) {
            return response()->json([
                "success" => true,
                "status" => "RecordDeleted",
                "message" => "Requested record deleted successfully.",
                "data" => null
            ]);
        }
        return response()->json([
            "success" => false,
            "status" => "failed",
            "message" => "Record couldn't delete!",
            "error" => "Unknown"
        ]);
    }
}
