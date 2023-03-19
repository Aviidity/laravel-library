@extends('layouts.welcome')
@section('content')
<div class="mt-3 d-flex flex-row gap-3">
    <form action="/books/create" method="GET">
        <button class="btn btn-primary text-light w-100" type="submit">Create Book</button>
    </form>
    <form action="/books" method="GET" class="col">
        <button name="search" class="btn btn-primary text-light mb-1" type="submit">Search</button>
        <input name="bookname" class="form-control w-75 d-inline" type="search" placeholder="Search">
    </form>
    <form action="/books" method="GET">
        <select name="categoryId" class="form-select d-inline w-75">
            <option value="any">Any genre</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        <button name="filter" class="btn btn-primary text-light mb-1" type="submit">Filter</button>
    </form>
</div>
@if(count($books) > 0)
<div class="row row-cols-5 g4">
    @foreach($books as $book)
    <div class="col my-2">
        <div class="card rounded-4 overflow-hidden shadow">
            <img style="object-fit: cover; height: 190px;" src="{{URL($book->picture)}}" alt="Card image cap">
            <div class="card-body">
                <h6 class="card-title m-0">{{$book->title}}</h6>
                <p class="card-text" style="height: 50px;">{{$book->author}}</p>
                <button class="d-inline btn border-primary" style="cursor: unset;">{{$book->price}}$</button>
                <form action="/books/{{$book->id}}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-primary">View</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div>
    {{$books->links()}}
</div>
@else
<p class="alert alert-info my-2 p-3 rounded">No books available</p>
@endif
@endsection