@extends('layouts.initial')

@section('content')
    
    <register-user-component arealist="{{json_encode($areas)}}"></register-user-component>
 
@endsection
