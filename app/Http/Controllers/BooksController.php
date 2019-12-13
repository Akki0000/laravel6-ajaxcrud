<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use DataTables;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::all();
        if($request->ajax())
        {
            $book = Book::latest()->get();

            return DataTables::of($book)
                            ->addIndexColumn()
                            ->addColumn('action', function($data){
                                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
                                $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
                                return $btn;    
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('book',compact('books'));
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
        Book::updateOrCreate(['id'=>$request->id],
                            ['name'=>$request->name,'author'=>$request->author]);
        return response()->json(['success'=>'Book Add Successfully.']);
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
-
+    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
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
        Book::findOrFail($id)->delete();
        return response()->json(['success'=>'Book Delete Successfully.']);
    }
}
