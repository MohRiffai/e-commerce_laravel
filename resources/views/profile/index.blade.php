<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Profile') }}
            </h2>
        </x-slot>
        <div class="container mt-4">
            {{ alertbs_form($errors) }}
            <a href="{{ route('profile.edit') }}" class="btn btn-primary mb-2">Edit Profil</a>
            <div class="card">
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
                    <p><strong>Alamat:</strong> {{ Auth::user()->alamat }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Phone:</strong> {{ Auth::user()->phone }}</p>
                    <p><strong>Bergabung Pada:</strong> {{ Auth::user()->created_at->format('d-m-Y') }}</p>
                    {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a> --}}
                </div>
            </div>
        @endsection
</x-app-layout>
