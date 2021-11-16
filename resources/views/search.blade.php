<div class="container">
   {{-- Название поля по каторому ищу--}}
    @foreach($users as $user)
        <li>{{$user['name']}}}</li>
    @endforeach
</div>

