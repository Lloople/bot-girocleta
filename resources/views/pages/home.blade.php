@extends('layout')

@section('content')
    <div class="flex flex-wrap mt-8">
        <div class="md:w-1/2">
            @foreach ($left as $leftInformation)
                @include($leftInformation)
            @endforeach
        </div>
        <div class="md:w-1/2">
            @foreach($right as $rightInformation)
                @include($rightInformation)
            @endforeach
        </div>
    </div>
@endsection
