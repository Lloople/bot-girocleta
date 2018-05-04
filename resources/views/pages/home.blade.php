@extends('layout')

@section('content')
    <div class="flex flex-wrap mt-8">
        <div class="md:w-1/2">
        @foreach ($left as $leftInformation)
            @include('information.' . str_replace('.blade.php', '', basename($leftInformation)))
        @endforeach
        
        </div>
        <div class="md:w-1/2">
        @foreach($right as $rightInformation)
                @include('information.' . str_replace('.blade.php', '', basename($rightInformation)))
    
        @endforeach
        </div>
    </div>
@endsection
