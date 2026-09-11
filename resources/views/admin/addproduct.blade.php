@extends('admin.maindesign')


@section('add_product')

@if(session('product_message'))
<div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px;">
    {{ session('product_message') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" role="alert" style="padding: 15px; background-color: #fde8e8; color: #9b1c1c; border: 1px solid #fbd5d5; border-radius: 6px; margin-bottom: 20px;">
    <ul style="margin-bottom: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<style>
    .form-field {
        margin-bottom: 20px;
        max-width: 500px;
    }
    .form-field label {
        display: block;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        margin-bottom: 8px;
    }
    .form-field label span { color: red; }
    .form-field input[type="text"],
    .form-field input[type="number"],
    .form-field input[type="file"],
    .form-field textarea,
    .form-field select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }
    .form-field textarea { height: 150px; resize: vertical; }
    .form-field .field-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 4px;
        display: block;
    }
</style>

<div class="container-fluid">
    <h3 class="h4 mb-4">Add Product</h3>

    <form action="{{route('admin.postaddproduct')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-field">
            <label>Product Title <span>*</span></label>
            <input type="text" name="product_title" value="{{ old('product_title') }}" placeholder="Enter product title" required>
            @error('product_title')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-field">
            <label>Product Description <span>*</span></label>
            <textarea name="product_description" placeholder="Enter product description..." required>{{ old('product_description') }}</textarea>
            @error('product_description')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-field">
            <label>Product Quantity <span>*</span></label>
            <input type="number" name="product_quantity" value="{{ old('product_quantity') }}" placeholder="Enter product quantity" required min="0">
            @error('product_quantity')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-field">
            <label>Product Price ($) <span>*</span></label>
            <input type="number" name="product_price" value="{{ old('product_price') }}" placeholder="Enter product price" required min="0" step="0.01">
            @error('product_price')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-field">
            <label>Product Image <span>*</span></label>
            <input type="file" name="product_image" accept="image/*" required>
            @error('product_image')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-field">
            <label>Product Category <span>*</span></label>
            <select name="product_category" required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                    <option value="{{$category->category}}" {{ old('product_category') == $category->category ? 'selected' : '' }}>{{$category->category}}</option>
                @endforeach
            </select>
            @error('product_category')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <input type="submit" name="submit" value="Add Product"
               style="background:#1e293b; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px;">
    </form>
</div>

@endsection