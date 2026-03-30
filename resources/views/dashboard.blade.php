@extends('admin.layout')

@section('content')

<h2 class="text-2xl font-bold mb-6">📊 Dashboard</h2>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-gray-500">Users</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-gray-500">Rooms</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalRooms }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h3 class="text-gray-500">Admin</h3>
        <p class="text-3xl font-bold mt-2">
            {{ \App\Models\User::where('role','admin')->count() }}
        </p>
    </div>

</div>

@endsection