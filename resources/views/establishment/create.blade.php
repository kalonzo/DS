@extends('layouts.front') 
@section('js_imports_head')
 
@endsection

@section('content')
<div class="main row">
	<div class="col-xs-12">



			
			<h1>Contact TODOParrot</h1>
			


{!! Form::open(array('route' => 'establishment', 'create' => 'form')) !!}







{!! Form::label('id', 'Description') !!}
{!! Form::label('id', 'Description', array('class' => 'foo')) !!}
{!! Form::text('name') !!}







<table border ='3'>
<tr>
	<td>{!! Form::radio('société', 'value') !!}</td>
	<td>{!! Form::radio('madame', 'value') !!}</td>
	<td>{!! Form::radio('monsieur', 'value') !!}</td> 
</tr>
<tr>
<td> {!! Form::label('Société / Etablissement') !!}
    {!! Form::text('name', null, 
        array('required', 
              'class'=>'form-control', 
              'placeholder'=>'Your name')) !!}</td>
</tr>

</table>










<div class="form-group">
    {!! Form::label('Your Name') !!}
    {!! Form::text('name', null, 
        array('required', 
              'class'=>'form-control', 
              'placeholder'=>'Your name')) !!}
</div>

<div class="form-group">
    {!! Form::label('Your E-mail Address') !!}
    {!! Form::text('email', null, 
        array('required', 
              'class'=>'form-control', 
              'placeholder'=>'Your e-mail address')) !!}
</div>

<div class="form-group">
    {!! Form::label('Your Message') !!}
    {!! Form::textarea('message', null, 
        array('required', 
              'class'=>'form-control', 
              'placeholder'=>'Your message')) !!}
</div>

<div class="form-group">
    {!! Form::submit('Contact Us!', 
      array('class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}
			
			
	
	
	</div>
</div>

@endsection @section('js_imports_footer') @endsection
