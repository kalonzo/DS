@if(!isset($reloaded) || !$reloaded)
<div class="row" id='ets-close-periods'>
@endif
    <div class="col-xs-12">
        <h5>Fermeture exceptionnelle</h5> 

        @if(checkModel($establishment))
        <div class="col-xs-12 highlight-container subform-collection form-group form-inline" data-subform-action="add_close_period" data-subform-reloader="#ets-close-periods">
            {!! Form::label('close_name','Titre', ['class' => 'text-right col-xs-6 col-sm-2']) !!}
            {!! Form::text('close_name', old('close_name'), ['class' => 'form-control col-xs-6 col-sm-2']) !!}
            <span class="col-xs-1 col-sm-0_5">&nbsp;du&nbsp;</span>
            {!! Form::date('close_start', old('close_start'), ['class' => 'form-control col-xs-5 col-sm-1_5']) !!}
            <span class="col-xs-1 col-sm-0_5">&nbsp;au&nbsp;</span>
            {!! Form::date('close_end', old('close_end'), ['class' => 'form-control col-xs-5 col-sm-1_5']) !!}
            <button type="button" class="btn btn-md pull-right text-uppercase col-xs-12 col-sm-2" onclick="addCollectionItem(this);">
                Ajouter
            </button>
        </div>

        @else
        <div class="row incomplete-sheet-disclaimer">
            <div class="col-xs-12">
                <p>
                    La saisie des périodes de fermeture sera accessible une fois votre établissement enregistré avec les informations minimales requises.
                </p>
            </div>
        </div>
        @endif
    </div>

    @if(checkModel($establishment))
        @php
        $closePeriods = $establishment->closePeriods()->whereRaw('end_date >= NOW()')->orderBy('start_date')->get();
        @endphp
        <ul class="col-xs-12 close-periods-list">
        @foreach($closePeriods as $closePeriod)
            <li class="close-periods-item">
                <span class="close-periods-label">{!! $closePeriod->getFullLabel() !!}</span>
                <span class="glyphicon glyphicon-remove close-periods-remove gallery-remove" aria-hidden="true" title="Supprimer cette période de fermeture" 
                          onclick="removeCollectionItem(this, '{!! $closePeriod->getUuid() !!}', 'delete_close_period')" data-subform-reloader="#ets-close-periods"></span>
            </li>
        @endforeach
        </ul>
    @endif

@if(!isset($reloaded) || !$reloaded)
</div>
@endif