@if(checkModel($businessType))
{!! Form::model($businessType, ['url' => '/admin/update/business_types/'.$businessType->getId(), 'method' => 'POST', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/admin/create/business_types', 'method' => 'PUT', 'files' => true]) !!}
@endif

<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('label','Label') !!}
        {!! Form::text('label', old('label'), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 form-group">
        {!! Form::label('status', 'Statut') !!}
        {!! Form::select('status', $status, old('status'), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 form-group">
        @php
            $media = null;
        @endphp
        @if(checkModel($businessType) && $businessType->media()->exists())
            @php
            $media = [$businessType->media()->first()];
            @endphp
        @endif
        <h5>Image</h5>
        @component('components.file-input', 
                            ['name' => 'media',
                            'class' => 'form-control',
                            'medias' => $media,
                            'fileType' => 'image'
                            ])

        @endcomponent
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        {!! Form::button('Enregistrer', ['type' => 'button', 'class' => 'form-data-button btn btn-default pull-right']) !!}
    </div>
</div>
{!! form::close() !!}