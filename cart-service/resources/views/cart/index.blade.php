@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Shopping Cart</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($cartItems) > 0)
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_id }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item->cart_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 100px; display: inline;">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('cart.delete', $item->cart_id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Your cart is empty!</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">Clear Cart</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
