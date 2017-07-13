@extends('layouts.front') 
@section('js_imports_head')
 
@endsection

@section('content')
       
	{!! Form::open(['route'=>'establishment.store']) !!} 
     
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="container">
	<!-- Form Name -->
	<legend>
		Etape 4
	</legend>
	<!-- Text input-->
	<div class="form-group">
		{!! Form::radio('title', 'Société') !!}{!! Form::label('Société') !!}{!!Form::radio('title', 'Madamme') !!}{!! Form::label('Madame') !!}{!!Form::radio('title', 'Monsieur') !!}{!! Form::label('Monsieur') !!}
	</div>
	<div class="form-group">
		  {!! Form::label('* Société / Etablissement') !!}  
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  {!! Form::text('companies@name', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'Entrez le nom de votre restaurant']) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		  {!! Form::label('* Prénom') !!}  
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  {!! Form::text('firstname ', old('firstname '), ['class'=>
				'form-control', 'placeholder'=>
				'']) !!}
			</div>
		</div>
	</div>
	<!-- Text input-->
	<div class="form-group">
		 {!! Form::label('* Nom de votre restaurant') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  {!! Form::text('Establishment.name', old('name'), ['class'=>
		'form-control', 'placeholder'=>
		'Enter Name']) !!}
			</div>
		</div>
	</div>
	<!-- Text input-->
	<div class="form-group">
		{!! Form::label('* Rue') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('street', old('street'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Email']) !!}
			</div>
		</div>
	</div>
        <div class="form-group">
		{!! Form::label('* Numéro de rue') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('street_number', old('street'), ['class'=>
				'form-control', 'placeholder'=>
				'']) !!}
			</div>
		</div>
	</div>
	<!-- Text input-->
	<div class="form-group">
		  {!! Form::label('* NPA') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  {!! Form::number('postal_code', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'']) !!}
			</div>
		</div>
	</div>
	<!-- Text input-->
	<div class="form-group">
		  {!! Form::label('* Localité') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('city', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}
			</div>
		</div>
	</div>
	<!-- Select Basic 
	<div class="form-group">
		{!! Form::label('Pays') !!}
		<div class="col-md-4 selectContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                                
				<select nailame="state" class="form-control selectpicker" >
					<option value=" " >Séléction du pays</option>
					<option>Suisse</option>
					<option>France</option>
				</select>
			</div>
		</div>
	</div>
        -->
	<!-- Text input-->
	<div class="form-group">
		  {!! Form::label('* Pays') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::number('id_country', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		  {!! Form::label('* Téléphone') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  {!! Form::text('Call_numbers.number', old('number'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}
			</div>
		</div>
	</div>
	<!-- Text input-->
	<div class="form-group">
		  {!! Form::label('* Fax') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  {!! Form::text('fax', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		  {!! Form::label('* e-mail') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>  
                {!! Form::text('email', old('email'), ['class'=>
		'form-control', 'placeholder'=>
		'Enter Message']) !!}
			</div>
		</div>
	</div>

	<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
		{!! Form::label('Email:') !!}{!! Form::text('email', old('email'), ['class'=>
		'form-control', 'placeholder'=>
		'Enter Email']) !!}
		<span class="text-danger">
			{{ $errors->
			first('email') }}
		</span>
	</div>

	<!-- Text area
	<div class="form-group">
		  {!! Form::label('Name:') !!}
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				{!! Form::text('name', old('name'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}  
			</div>
		</div>
	</div>
	-->
	<!-- Success message -->
	<div class="alert alert-success" role="alert" id="success_message">
		Success 
		<i class="glyphicon glyphicon-thumbs-up"></i>
		 Thanks for contacting us, we will get back to you shortly.
	</div>
	<!-- Button -->
	<div class="form-group">
		<label class="col-md-4 control-label"></label>
		<div class="col-md-4">
			<button type="submit" class="btn btn-warning" >Envoyer <span class="glyphicon glyphicon-send"></span></button>
		</div>
	</div>
        
        	<div class="form-group">
		
		<div class="col-md-4 inputGroupContainer">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::number('id_establishment', old('CallNumber.id_establishment'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}
			</div>
		</div>
	</div>
        
</div>
   <!-- /.container -->

	{!! Form::close() !!}

@endsection @section('js_imports_footer') @endsection