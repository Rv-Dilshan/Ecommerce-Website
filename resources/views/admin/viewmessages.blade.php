@extends('admin.maindesign')

@section('view_messages')

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
        background-color: #1e293b; 
        color: #ffffff;
        font-weight: 600;
    }

    .pro-table th, .pro-table td {
        padding: 14px 20px;
        vertical-align: middle; 
    }

    .pro-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    .pro-table tbody tr:nth-of-type(even) {
        background-color: #f8fafc;
    }

    .pro-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .pro-table tbody tr:last-of-type {
        border-bottom: 2px solid #1e293b;
    }
</style>

<div class="container-fluid">
    <div class="title-block d-flex justify-content-between align-items-center mb-4">
        <h3 class="h4">Customer Messages</h3>
    </div>

    <div class="custom-table-container">
        <table class="pro-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th style="width: 40%;">Message</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr>
                    <td style="white-space: nowrap;">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                    <td style="font-weight: 600;">{{ $msg->name }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ $msg->phone ?? '-' }}</td>
                    <td><div style="background:#f1f5f9; padding:10px; border-radius:6px; font-style:italic;">"{{ $msg->message }}"</div></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px;">No messages received yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
