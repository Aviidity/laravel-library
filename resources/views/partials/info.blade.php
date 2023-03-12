@extends('layouts.welcome')
@section('content')
<div class="card shadow flex-row my-4 p-2 rounded-4">
    <img src="{{URL($book->picture)}}" alt="cover" class="card-img-top rounded-4 d-inline bg-dark" style="width: 380px; height: 550px; object-fit: cover;">
    <div class="card-body position-relative px-5 bg">
        <h1 class="card-title my-1  ">
            {{$book->title}}
            <span class="text-primary">{{$book->price}}$</span>
        </h1>
        <p class="fs-5">{{$book->author}}</p>
        <p>{{$book->description}}</p>
        <div class="position-absolute fixed-bottom px-5 pb-2">
            <p class="d-inline">Publish Date: {{$book->published_date}}</p>
            <p class="d-inline mx-5">Last Update: {{$book->updated_at}}</p>
            <div class="mt-3">
                <form action="/books/{{$book->id}}/edit" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-primary px-4">Edit</button>
                </form>
                <form action="/books/{{$book->id}}" method="POST" class="d-inline">
                    @method('Delete')
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection