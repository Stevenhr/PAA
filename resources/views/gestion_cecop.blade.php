@extends('master')

@section('script')
	@parent
    <script src="{{ asset('public/Js/PAA/direccionGeneral.js') }}"></script>	
@stop

@section('content') 
<div id="main" class="content" data-url="cecop"></div>
Cecop
@stop