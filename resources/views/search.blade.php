@extends('layouts.app')

@section('content')
    <div class="text-center m-5">
        <p>
            Search LIWEWIRE
        </p>
        @livewire('search')
    </div>

<div class="container text-center">
   {{-- Название поля по каторому ищу--}}
    Search SCATCH
    @foreach($users as $user)
        <li>{{$user['name']}}}</li>
    @endforeach
</div>
@endsection
