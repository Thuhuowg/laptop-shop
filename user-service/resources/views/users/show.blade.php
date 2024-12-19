@extends('layouts.app')

@section('content')
<h1>User Details</h1>
<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<a href="{{ route('users.index') }}">Back to list</a>
@endsection
