@extends('admin.maindesign')


@section('add_category')

@if(session('category_message'))
<div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px;">
    {{ session('category_message') }}
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

<div class="container-fluid">
    <h3 class="h4 mb-4">Add Category</h3>

    <form action="{{route('admin.postaddcategory')}}" method="POST" style="max-width: 500px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display:block; font-weight:600; color:#475569; font-size:14px; margin-bottom:8px;">Category Name <span style="color:red;">*</span></label>
            <input type="text" name="category" value="{{ old('category') }}" placeholder="Enter category name" required
                   style="width:100%; padding:10px 14px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; outline:none;">
            @error('category')
                <span style="color: #dc2626; font-size: 13px; margin-top: 4px; display:block;">{{ $message }}</span>
            @enderror
        </div>
        <input type="submit" name="submit" value="Add Category"
               style="background:#1e293b; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px;">
    </form>
</div>

@endsection