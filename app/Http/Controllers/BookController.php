<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        try {
            $books = DB::table('books')->paginate(10);
            $data = ['books' => $books];
            return response()->view('partials.list', $data, 200);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while retrieving the books, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function show($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->first();
            if (!$book) {
                $data = ['msg' => 'The book your trying to search does not exist', 'status' => 404];
                return response()->view('partials.response', $data, 404);
            }
            return response()->view('partials.info', ['book' => $book], 200);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while loading the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function create()
    {
        return response()->view('partials.form');
    }
    public function store(Request $request)
    {
        // Fetch the file
        $imageFile = $request->file('picture');

        // Store the uploaded file in the public dir if there is otherwise a default file will be used
        if ($imageFile) {
            $imageFileName = $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('images', $imageFileName);
        } else {
            $path = 'default.jpg';
        }

        try {
            DB::table('books')->insert([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'published_date' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'picture' => $path
            ]);
            $data = ['msg' => 'Book created successfully.', 'status' => 200];
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while creating the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function edit($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->first();
            if (!$book) {
                $data = ['msg' => 'The book your trying to edit does not exist', 'status' => 404];
                return response()->view('partials.response', $data, 404);
            }
            return response()->view('partials.form', ['book' => $book]);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while loading the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Fetch the file
        $imageFile = $request->file('picture');

        // Store the uploaded file in the public dir if there is otherwise the file will be the same
        if ($imageFile) {
            $imageFileName = $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('images', $imageFileName);
        } else {
            $path = DB::table('books')->where('id', $id)->value('picture');
        }

        try {
            $book = DB::table('books')->where('id', $id)->update([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'updated_at' => Carbon::now(),
                'picture' => $path
            ]);
            $data = ['msg' => 'Book updated successfully.', 'status' => 200];
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while updating the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function destroy($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->delete();
            $data = ['msg' => 'Book deleted succesfully', 'status' => 200];
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            $data = ['msg' => 'An error ocurred while deleting the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
}
