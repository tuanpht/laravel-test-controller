@extends('app')

@section('title', 'Create Product')

@section('content')
<div class="container">
    @if (session()->has('product'))
    <hr>
    <div class="alert alert-success">
        <span>Product created #{{ session()->get('product')->id }}</span>
    </div>
    @endif
    @if ($errors->any())
    <hr>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <hr>
    <form method="POST" action="{{ action([\App\Http\Controllers\ProductController::class, 'store']) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku">
        </div>
        <div class="form-group">
            <label for="qty">Quantity</label>
            <input type="number" class="form-control" id="qty" name="qty" min="0">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image">
                <label class="custom-file-label" for="image">Upload image</label>
            </div>
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="10"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
