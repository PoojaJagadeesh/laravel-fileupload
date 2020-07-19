<?php

namespace App\Http\Controllers;

use App\fileupload;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;


class FileuploadController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'file' => 'required',
            'file.*' => 'mimes:doc,pdf,docx,txt,png,jpeg,jpg,gif'
          ]);
    
           if($request->hasfile('file'))
            {
               
                $upload_path = public_path('documents');
                $file_name = $request->file->getClientOriginalName();
                $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
                $request->file->move($upload_path, $generated_new_name);
                 
                $insert['title'] = $file_name;
               
                $check = fileupload::insertGetId($insert);
            }
            
         //  $check = fileupload::create($insert);
    
         return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
    
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fileupload  $fileupload
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        if ( $request->input('showdata') ) {
            return fileupload::orderBy('created_at', 'desc')->get();
            }
            $columns = ['title','created_at'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = fileupload::select('title', 'created_at');
            if ($search_input) {
            $query->where(function($query) use ($search_input) {
            $query->where('title', 'like', '%' . $search_input . '%')
            ->orWhere('created_at', 'like', '%' . $search_input . '%');
            });
            }
            $files = $query->paginate($length);
            return ['data' => $files];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fileupload  $fileupload
     * @return \Illuminate\Http\Response
     */
    public function edit(fileupload $fileupload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fileupload  $fileupload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fileupload $fileupload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fileupload  $fileupload
     * @return \Illuminate\Http\Response
     */
    public function destroy(fileupload $fileupload)
    {
        //
        if($fileupload) {
            $fileupload->delete();
            }
            return 'File deleted';
    }
}
