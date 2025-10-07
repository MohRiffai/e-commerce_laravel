<x-app-layout>
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight bg-green">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <div class="card bg-primary text-white card-rounded">
            <div class="card-body text-center pt-4 bg-success">
                <h4 class="card-title">
                    <b><i class="fas fa-check me-1"></i></b> 
                    Selamat Datang, <b>{{ auth()->user()->name }}</b>
                </h4>
                <a href="{{ route('home.index') }}" target="_blank" class="btn btn-primary btn-lg mt-2">
                    <i class="fas fa-rocket me-2"></i> Lihat Website
                </a>
            </div>
        </div>
    </div>
@endsection
</x-app-layout>
