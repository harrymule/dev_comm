<?php

namespace App\Http\Controllers;

use App\Datatable\DatatablePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\DataResource;
use App\Models\main_data;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class MainDataController extends BaseController
{

    public function index()
    {
        $data = main_data::select('name','type','description')->jsonPaginate(10);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'image' => ['required', 'mimes:jpg,jpeg,bmp,png ' , File::image()->min(2)->max(5000)],
            'type' => ['required', Rule::in([1,2,3]) ]
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->has('image')) {

            $image_org_name = $input['image']->getCLientOriginalName();
            $image_storename =base64_encode($input['image']). '.' . $input['image']->getClientOriginalExtension();
            $image_size = $input['image']->getSize();
            $pc_path = storage_path('private');
            $input['image']->move($pc_path, $image_storename);
            $input['image'] = $image_storename;
        }

        // print_r($input);
        // exit;

        $data = main_data::create($input);

        $response = [
            'name' => $data['name'],
            'type'=> $data['type'],
            'description'=> $data['description']
        ];
        $response = json_decode(json_encode($response), FALSE);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = main_data::find($id);

        if (is_null($data)) {
            return $this->sendError('Data not found.');
        }

        return $this->sendResponse(new DataResource($data), 'Data retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, main_data $data)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data->name = $input['name'];
        $data->description = $input['description'];
        $data->image = $input['image'];
        $data->type = $input['type'];
        $data->save();

        return $this->sendResponse(new DataResource($data), 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(main_data $data)
    {
        $data->delete();

        return $this->sendResponse([], 'Data deleted successfully.');
    }


     /**
     * get records by page from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getRecordsByPage($id){
        $paginate = 10;
        $skip = ($id*$paginate)-$paginate;
        $prevUrl = $nextUrl = '';
        if($skip>0){
            $prevUrl = $id - 1;
        }
        $data = main_data::select('name','type','description')->orderBy('id', 'desc')->skip($skip)->take($paginate)->get();
        if($data->count()>0){
            if($data->count()>=$paginate){
                $nextUrl = $id + 1;
            };
            $response = [$data, $prevUrl, $nextUrl,];
            return  response()->json($response);
        }
        return response()->json($data);
}


/**
     * get records by page from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getRecord($id){


        $data = main_data::find($id);
        $storage_path = storage_path("private").'\\'.$data['image'];
        $data['image_url'] = Storage::temporaryUrl($data['image'], now()->addMinutes(10));

        $response = [
            'name' => $data['name'],
            'type'=> $data['type'],
            'description'=> $data['description'],
            'temp_image_url' => $data['image_url']
        ];
        return response()->json($response);
}







}
