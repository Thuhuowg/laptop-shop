<!-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tạo người dùng mới</h1>

        {{-- Hiển thị lỗi nếu có --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form tạo người dùng --}}
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="username">Tên người dùng</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone_number">Số điện thoại</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
            </div>
            <button type="submit" class="btn btn-success">Tạo</button>
        </form>
    </div>
@endsection -->
