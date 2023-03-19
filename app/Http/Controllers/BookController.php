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
    public function index(Request $request)
    {
        try {
            $categoryId = $request->input('categoryId');
            $bookName = $request->input('bookname');

            if (!$categoryId | $categoryId == 'any') {
                $books = DB::table('books')->paginate(10);
            } else {
                $books = DB::table('books')
                    ->join('book_category', 'books.id', 'book_category.book_id')
                    ->where('book_category.category_id', $categoryId)->paginate(5);
            }

            if ($bookName) {
                $books = DB::table('books')->where('title', 'LIKE', '%' . $bookName . '%')->paginate(5);
            }

            Log::channel('library')->info("Books from the DATABASE fetched");
            $categories = DB::table('categories')->get();
            $data = ['categories' => $categories, 'books' => $books];
            return response()->view('partials.list', $data, 200);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
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
            Log::channel('library')->info("Book with ID " . $id . " fetched from the DATABASE");
            return response()->view('partials.info', ['book' => $book], 200);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
            $data = ['msg' => 'An error ocurred while loading the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function create()
    {
        try {
            $categories = DB::table('categories')->get();
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
            return response()->view('partials.form', ['categories' => $categories]);
        }
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

            if ($request->input('categoryId') && $request->input('categoryId') != 'none') {
                $bookId = DB::table('books')->get()->max('id');
                DB::table('book_category')->insert([
                    'book_id' => $bookId,
                    'category_id' => $request->input('categoryId')
                ]);
            }

            Log::channel('library')->info("Book with ID " . $bookId . " was created from the DATABASE");
            $data = ['msg' => 'Book created successfully.', 'status' => 200];
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
            $data = ['msg' => 'An error ocurred while creating the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function edit($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->first();
            $category = DB::table('categories')
                ->join('book_category', 'categories.id', 'book_category.category_id')
                ->where('book_category.book_id', $book->id)->first();
            if (!$book) {
                $data = ['msg' => 'The book your trying to edit does not exist', 'status' => 404];
                return response()->view('partials.response', $data, 404);
            }

            // LOG ???
            $categories = DB::table('categories')->get();
            return response()->view('partials.form', ['book' => $book, 'category' => $category, 'categories' => $categories]);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
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
            DB::table('books')->where('id', $id)->update([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'updated_at' => Carbon::now(),
                'picture' => $path
            ]);

            if($request->input('categoryId') != 'none'){
                DB::table('book_category')
                    ->where('book_id',$id)
                    ->update(['category_id' => $request->input('categoryId')]);
            }else{
                DB::table('book_category')->where('book_id',$id)->delete();
            }

            Log::channel('library')->info("Book with ID " . $id . " was updated in the DATABASE");
            $data = ['msg' => 'Book updated successfully.', 'status' => 200];
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
            $data = ['msg' => 'An error ocurred while updating the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
    public function destroy($id)
    {
        try {
            DB::table('books')->where('id', $id)->delete();
            $data = ['msg' => 'Book deleted succesfully', 'status' => 200];
            Log::channel('library')->info("Book with ID " . $id . " was deleted from the DATABASE");
            return response()->view('partials.response', $data, 200);
        } catch (QueryException $e) {
            Log::channel('library')->error($e->getMessage());
            $data = ['msg' => 'An error ocurred while deleting the book, try again later!', 'status' => 500];
            return response()->view('partials.response', $data, 500);
        }
    }
}
