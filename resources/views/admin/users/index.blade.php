@extends('admin.layout')

@section('content')

<h2 class="text-2xl font-bold mb-4">👤 Quản lý User</h2>

<table class="w-full bg-white shadow rounded-lg">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Tên</th>
            <th>Email</th>
            <th>Role</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr class="border-t text-center">

            <td class="p-3">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
                <span class="px-2 py-1 rounded 
                    {{ $user->role == 'admin' ? 'bg-green-200' : 'bg-gray-200' }}">
                    {{ $user->role }}
                </span>
            </td>

            <td>

                @if(auth()->user()->role === 'admin')

                    @if(auth()->id() != $user->id)

                        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                            @csrf

                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="role"
                                    onchange="this.form.submit()"
                                    class="sr-only peer"
                                    {{ $user->role == 'admin' ? 'checked' : '' }}>

                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-500 relative transition">
                                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition 
                                        peer-checked:translate-x-5"></div>
                                </div>
                            </label>
                        </form>

                    @else
                        <span class="text-gray-400">(Bạn)</span>
                    @endif

                @else
                    <span class="text-red-400">Không có quyền</span>
                @endif

            </td>

        </tr>
        @endforeach
    </tbody>
</table>

@endsection