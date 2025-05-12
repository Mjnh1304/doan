@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ __('messages.edit_title') }}</h1>

@if (session('success'))
<div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
    <strong>{{ __('messages.error') }}:</strong>
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- PHẦN 1: Tên hiển thị --}}
<div class="bg-gray-800 text-white rounded-lg p-6 mb-6 shadow-md">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="section" value="username">
        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium">{{ __('messages.display_name') }}</label>
            <input id="name" name="name" class="w-full text-black p-2 rounded" required value="{{ old('name', $user->name) }}">
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            {{ __('messages.save_changes') }}
        </button>
    </form>
</div>

{{-- PHẦN 2: Email --}}
<div class="bg-gray-800 text-white rounded-lg p-6 mb-6 shadow-md">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="section" value="email">
        <div class="mb-4">
            <label for="email" class="block mb-1 font-medium">{{ __('messages.email_address') }}</label>
            <input id="email" name="email" class="w-full text-black p-2 rounded" required value="{{ old('email', $user->email) }}">
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            {{ __('messages.save_and_verify') }}
        </button>
    </form>
</div>

{{-- PHẦN 3: Đổi mật khẩu --}}
<div class="bg-gray-800 text-white rounded-lg p-6 mb-6 shadow-md">
    <h2 class="text-xl font-semibold mb-4">{{ __('messages.change_password') }}</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="current_password" class="block mb-1 font-medium">{{ __('messages.current_password') }}</label>
            <input id="current_password" name="current_password" type="password" class="w-full text-black p-2 rounded" required>
            @error('current_password')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1 font-medium">{{ __('messages.new_password') }}</label>
            <input id="password" name="password" type="password" class="w-full text-black p-2 rounded" required>
            @error('password')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1 font-medium">{{ __('messages.confirm_password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full text-black p-2 rounded" required>
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            {{ __('messages.update_password') }}
        </button>
    </form>
</div>
@endsection