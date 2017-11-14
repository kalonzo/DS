@if(checkModel($paymentMethod))
{!! Form::model($paymentMethod, ['url' => '/admin/update/payment_methods/'.$paymentMethod->getId(), 'method' => 'POST', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/admin/create/payment_methods', 'method' => 'PUT', 'files' => true]) !!}
@endif

<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('name','Label') !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
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
            $logo = null;
        @endphp
        @if(checkModel($paymentMethod) && $paymentMethod->logo()->exists())
            @php
            $logo = [$paymentMethod->logo()->first()];
            @endphp
        @endif
        <h5>Image</h5>
        @component('components.file-input', 
                            ['name' => 'logo',
                            'class' => 'form-control',
                            'medias' => $logo,
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
{!! Form::close() !!}