{{-- File: resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <h1>Profil Saya</h1>

    <table class="info">
        <tr>
            <th>Nama</th>
            <td>{{ $user['name'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user['email'] }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ ucfirst($user['role']) }}</td>
        </tr>
    </table>

    <h2>Ganti Password</h2>

    <form action="{{ route('profile.password') }}" method="POST" class="form-box">
        @csrf
        @method('PUT')

        <label for="password_lama">Password Lama</label>
        <input type="password" name="password_lama" id="password_lama">
        @error('password_lama')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_baru">Password Baru</label>
        <input type="password" name="password_baru" id="password_baru">
        @error('password_baru')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
        <input type="password" name="password_baru_confirmation" id="password_baru_confirmation">

        <button type="submit" class="btn">Simpan Password Baru</button>
    </form>
@endsection
