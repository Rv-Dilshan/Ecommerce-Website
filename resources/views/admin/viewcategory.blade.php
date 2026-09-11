@extends('admin.maindesign')

@section('view_category')

@if(session('deletecategory_message'))
    <div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        {{ session('deletecategory_message') }}
    </div>
@endif

@if(session('deletecategory_error'))
    <div class="alert alert-danger" role="alert" style="padding: 15px; background-color: #fde8e8; color: #9b1c1c; border: 1px solid #fbd5d5; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        <strong>Error!</strong> {{ session('deletecategory_error') }}
    </div>
@endif

@if(session('category_updated_message'))
    <div class="alert alert-success" role="alert" style="padding: 15px; background-color: #def7ec; color: #03543f; border: 1px solid #bfecdb; border-radius: 6px; margin-bottom: 20px; font-family: sans-serif;">
        {{ session('category_updated_message') }}
    </div>
@endif

<style>
    .custom-table-container {
        margin: 20px 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .pro-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        text-align: left;
    }

    .pro-table thead tr {
        background-color: #1e293b; /* Modern Dark Navy Blue background */
        color: #ffffff;
        font-weight: 600;
    }

    .pro-table th, .pro-table td {
        padding: 14px 20px;
    }

    .pro-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    /* Zebra striping (එක පෙළක් හැර පෙළක් වෙනස් පාටක් ගැන්වීම) */
    .pro-table tbody tr:nth-of-type(even) {
        background-color: #f8fafc;
    }

    /* Hover effect (මවුස් එක උඩින් යනකොට highlight වීම) */
    .pro-table tbody tr:hover {
        background-color: #f1f5f9;
        cursor: pointer;
    }

    /* Last row border-bottom adjustment */
    .pro-table tbody tr:last-of-type {
        border-bottom: 2px solid #1e293b;
    }
</style>

<div class="custom-table-container">
    <table class="pro-table">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->category }}</td>
                <td><a href="{{route('admin.categoryupdate',$category->id)}}" style="color:green ">Update</a></td>
                <td>
                    <form action="{{route('admin.categorydelete',$category->id)}}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:red; padding:0; cursor:pointer; font:inherit; text-decoration:underline;">Delete</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection