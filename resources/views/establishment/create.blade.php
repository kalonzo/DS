@extends('layouts.front') 
@section('js_imports_head')
 
@endsection

@section('content')

	{!! Form::open(['route'=>'establishment.store']) !!} 
        {!! Form::hidden('id_address', 0) !!}
        {!! Form::hidden('id_logo', 0) !!}
        
        {!! Form::hidden('id_user_owner', 0) !!}

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

			{!! Form::label('Name:') !!}

			{!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}

			<span class="text-danger">{{ $errors->first('name') }}</span>

		</div>


		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

			{!! Form::label('Email:') !!}

			{!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}

			<span class="text-danger">{{ $errors->first('email') }}</span>

		</div>


		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">

			{!! Form::label('Message:') !!}

			{!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Enter Message']) !!}

			<span class="text-danger">{{ $errors->first('message') }}</span>

		</div>


		<div class="form-group">

			<button class="btn btn-success">Contact US!</button>

		</div>


	{!! Form::close() !!}

@endsection @section('js_imports_footer') @endsection
