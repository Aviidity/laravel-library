@extends('layouts.welcome')
@section('content')
<form action="{{!isset($book) ? '/books' : '/books/'.$book->id}}" method="post" enctype="multipart/form-data">
    <div class="card my-4 p-2 rounded-4 bg-light shadow">
        <div class="row">
            <div class="col" style="width: 100px;">
                <input type="file" name="picture" class="form-control " onchange="preview()">
                <img id="frame" class="card-img mt-2 rounded-4" style="width: 380px; height: 550px; object-fit: cover;" src="{{isset($book) ? URL($book->picture) : URL('default.jpg')}}">
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Title</span>
                        </div>
                        <input type="text" class="form-control" name="title" value="{{isset($book) ? $book->title : ''}}" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Author</span>
                        </div>
                        <input type="text" class="form-control" name="author" value="{{isset($book) ? $book->author : ''}}" required>
                    </div>
                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" name="price" value="{{isset($book) ? $book->price : ''}}" step="any" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <textarea name="description" rows="18" placeholder="Description..." class="form-control mb-2" style="resize: none;" required>{{isset($book) ? $book->description : ''}}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        @csrf
                        @if(!isset($book))
                        <button type="submit" class="btn btn-primary px-5">Create</button>
                        @else
                        @method('PUT')
                        <button type="submit" class="btn btn-primary px-5">Update</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection