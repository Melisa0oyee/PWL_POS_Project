<!-- profile.blade.php -->

@extends('layouts.template')

@section('content')
<h1>Profil Pengguna</h1>

<!-- Tampilkan informasi pengguna lainnya di sini -->

<form action="{{ url('/user/update-avatar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="avatar" accept="image/*" required>
    <button type="submit">Update Foto Profil</button>
</form>

@endsection
