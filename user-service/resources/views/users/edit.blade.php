@extends('layouts.app')

@section('content')
    <h1>Chỉnh sửa thông tin người dùng</h1>
    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password (bỏ trống nếu không muốn thay đổi)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $user->address }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
