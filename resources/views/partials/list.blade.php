@extends('layouts.welcome')
@section('content')
@if(count($books) > 0)
<div class="row row-cols-5 g4">
    @foreach($books as $book)
    <div class="col my-4">
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
<div  style="position: absolute;">
{{ $books->links() }}
</div>
@else
<p class="alert alert-info my-5 p-3 rounded">No books available</p>
@endif
@endsection