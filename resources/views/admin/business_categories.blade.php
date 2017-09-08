@if(checkModel($businessCategory))
{!! Form::model($businessCategory, ['url' => '/admin/business_categories/'.$businessCategory->getUuid(), 'method' => 'PUT', 'files' => true]) !!}
@else
{!! Form::open(['url'=>'/establishment', 'method' => 'put', 'files' => true]) !!}
@endif

    <div class="panel-group form-accordion"  role="tablist" >
        <div class="panel-body container">
            <div class="row">
                <div class='col-md-12 form-group'>
                    {!! Form::select('type', $businessCategory->getLabelByType(), $businessCategory->getType(), ['class' => 'form-control select2']) !!}
                </div>
            </div>
            <div class="row">
                <div class='col-md-12 form-group'>
                    {!! Form::text('name',$businessCategory->getName(), old('name'), ['class' => 'form-control'] ) !!}
                </div>
            </div>
            <div class="row">
                <div class='col-md-12'>
                    <h6> {!! Form::label('status',$status[0]) !!}</h6>
                </div>
            </div>
            <div class="row">
                <div class='col-md-12 form-group'>
                    <input type="submit" value="Corriger / Valider" />
                </div>
            </div>
        </div>
    </div>
    {!! Form::submit('Valider', array('class'=>'btn pull-right')) !!}
{!! form::close() !!}
