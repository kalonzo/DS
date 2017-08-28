<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading11">
        <a role="button" data-toggle="collapse" data-parent="#establishment_form_accordion" href="#collapse11" 
           aria-expanded="true" aria-controls="collapse11">
            <div class="container">
                <h4 class="panel-title">Menus</h4>
            </div>
        </a>
    </div>
    <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading11">
        <div class="panel-body container">
            <div class="row">
                <div class="col-md-12 form-group">
                    Veuillez insérer votre/vos menu(s). Choissisez votre menu en PDF, Word ou JPEG depuis votre ordinateur.
                </div> 
            </div>
            <div class="row"> 
                <div class="col-xs-8 col-sm-8 form-group">
                    {!! Form::label('menu_name','Nom de votre menu') !!}	
                    {!! Form::text('menu_name', old('menu_name'),['class' => 'form-control',]) !!}
                </div>
                <div class="col-xs-4 col-sm-4 form-group {{ $errors->has('logo_menu') ? 'has-error' : '' }}">
                    {!! Form::label('logo_menu','Image pour votre menu') !!}	
                    {!! Form::file('logo_menu', ['class' => 'form-control bootstrap-file-input file-input-single']) !!}
                </div>      
            </div>
            <!-- Composant vignette -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            mars  2017  
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="X" />
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="view" /> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            avril  2017  
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="X" />
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="view" /> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            mai  2017  
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="X" />
                        </div>
                        <div class="col-md-4 form-group">
                           <input type="button" value="view" /> 
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            @lang('Prix moyen de votre restaurant : Prix moyen à la carte hors boisson. En aucun cas il ne peut être considéré comme contractuel') 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 form-group">
                            {!! Form::text('average_price_min')!!}
                        </div>
                        <div class="col-md-2 form-group">
                            {!! Form::text('average_price_max')!!}
                        </div>
                        <div class="col-md-2 form-group">
                            {!! Form::select("currency",['placeholder' => 'CHF']) !!}
                        </div>
                        <div class="col-md-6 form-group">
                            <button type="button" class="btn btn-md pull-right text-uppercase">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xd-12 form-group">
                    <div class="row"> 
                        <div class="col-xs-8  form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('dish_name','Nom de l\'assiette') !!}	
                            {!! Form::text('dish_name', old('dish_name'),['class' => 'form-control',]) !!}
                        </div>
                        <div class="col-xs-4  form-group {{ $errors->has('logo_assiette') ? 'has-error' : '' }}">
                            {!! Form::label('logo_assiette','Image pour votre assiette') !!}
                            {!! Form::file('logo_assiette', ['class' => 'form-control bootstrap-file-input file-input-single']) !!}
                        </div>      
                    </div> 
                    <div class="row"> 
                        <div class="col-xs-12  form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {!! Form::label('description','Description de l\'assiette') !!}	
                            {!! Form::text('description', old('label'),['class' => 'form-control',]) !!}
                        </div>   
                    </div> 
                    <div class="row"> 
                        <div class="col-xs-6  form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                            {!! Form::label('price','Prix') !!}	
                            {!! Form::text('price', old('prix'),['class' => 'form-control',]) !!}
                        </div>      
                        <div class="col-xs-6  form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                            {!! Form::label('currency','Monnaie') !!}	
                            {!! Form::text('currency', old('currency'),['class' => 'form-control',]) !!}
                        </div>      
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <button type="button" role="button" class="btn btn-md pull-right text-uppercase" onclick="goToNextAccordion(this);">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>                    
</div>