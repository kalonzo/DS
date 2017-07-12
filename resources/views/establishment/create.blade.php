@extends('layouts.front') 
@section('js_imports_head')
 
@endsection

@section('content')

<div class="col-xs-12">

{!! Form::open(array('route' => 'establishment', 'create' => 'form')) !!}

<div class ="form-name">
    {!! Form::label('Société') !!}
    {!! Form::radio('société', 'value') !!}
    </div>
<div>
    {!! Form::label('Madame') !!}
    {!! Form::radio('madame', 'value') !!}
    </div>
<div>
    {!! Form::label('Monsieur') !!}
    {!! Form::radio('monsieur', 'value') !!}
</div>
   	 
<div class ="form-establishment">
    
 {!! Form::label('*Société / Etablissement') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    
</div>

<div>
    
    {!! Form::label('*Prénom') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
              </div>
<div>
    {!! Form::label('*Nom') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'Your name')) !!}
</div>
    
<div>
    {!! Form::label('*Rue') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
              </div>
<div>
    {!! Form::label('*Numéro') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
</div>
    
<div>
    {!! Form::label('*P.O. BOX') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
</div>
    
<div>
    {!! Form::label('*NPA') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
              </div>
<div>
     {!! Form::label('*Localité') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
</div>
    
<div>
    {!! Form::label('*Pays') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}

</div>
    
<div>
    {!! Form::label('*Téléphone') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
              
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::label('*Téléphone professionnel') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
</div> 
<div>
    

    {!! Form::label('*FAX') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::label('*Mobile') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}
    
</div>
<div>
    
        {!! Form::label('*Pays') !!}
    {!! Form::text('name', null, 
        array( 
              'class'=>'form-control', 
              'placeholder'=>'')) !!}

</div>

{{ Form::submit() }}
{!! Form::close() !!}
</div>

@endsection @section('js_imports_footer') @endsection
