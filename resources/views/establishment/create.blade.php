@extends('layouts.front') 
@section('js_imports_head')

@endsection

@section('content')
       
{!! Form::open(['route'=>'establishment.store']) !!}    
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="accordion" id="accordionid">
  <div class="accordion-group">
    <div class="heading">  
        <nav class="nav-wrapper-clone">
            <div class="col-md-6">
               <img id="preview" src="placeholder.png" height="100px" width="100px" />
            
            {!! Form::text('name', old('name'), [
                'class'=>'form-control',
                'placeholder'=>'Restaurant Nom de  votre restaurant',
                'id'=>'logo'
                ]) !!}
                
           

                {!! Form::file('id_logo', array(
                'class' => 'name',
                'onchange' => 'previewImage(this)'
                )) !!}       
            </div>
        </nav>
    </div>      
      
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#one">
        <h5>Emplacement</h5>
      </a>
    </div>
    <div id="one" class="collapse">
      <div class="accordion-inner">
        
	<!-- Saisie de l'adresse de l'établissemntnt-->
	<div class="form-group  accordion-inner">
		{!! Form::label('* Addresse') !!}	
            <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('street', old('street'), [
                                'class'=>'form-control',
                                'placeholder'=>'',
                                'id'=>'street'
                                ]) !!}
            </div>	
	</div>
	<div class="form-group  accordion-inner">
		{!! Form::label('  Addresse 2') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('street', old('street'), [
                                'class'=>'form-control',
                                'placeholder'=>'',
                                'id'=>'street'
                                ]) !!}
			</div>
		
	</div>
        <div class="form-group  accordion-inner">
		{!! Form::label('* N° Rue') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('street_number', old('street_number'), ['class'=>
				'form-control', 
                                'placeholder'=>'',
                                'id'=>'street_number'
                                ]) !!}
			</div>
		
	</div>
	<!-- Text input-->
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Code postal') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  {!! Form::text('postal_code', old('postal_code'), [
                                  'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'postal_code'
                                ]) !!}
			</div>
		
	</div>
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Ville') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('city', old('city'), ['class'=>
				'form-control',
                                'placeholder'=>'',
                                'id'=>'city'
                                ]) !!}
			</div>
		
	</div>
        <div class="form-group  accordion-inner">
		  {!! Form::label('* Pays') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('country', old('country'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'country'
                                ]) !!}
                                 <p id="demo"></p>
			</div>
		
	</div>
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Latitude') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('latitude', old('latitude'), [
                                  'class'=>'form-control',
                                  'placeholder'=>'',
                                  'id'=> 'lat'
                                  ]) !!}
			</div>
		
	</div>           
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Longitude') !!}
	
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('lng', old('longitude'), ['class'=>
				'form-control', 'placeholder'=>'',
                                'id'=>'lng'
                                ]) !!}
			</div>
		
                  <div>
                       <input id="localize" type="button" value="Chercher la direction de mon restaurant"  onclick="getCoords()">
                  </div> 
	</div>
        
      </div>
    </div>  
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#two">
        <h5>Contacts</h5>
      </a>
    </div>
    <div id="two" class="collapse">
      <div class="accordion-inner">
        
          
          <div class="form-group  accordion-inner">
		  {!! Form::label('* Téléphone pour réservation') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                	{!! Form::text('number', old('number'), [
                                  'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'number'
                                ]) !!}
			</div>
		
	</div>
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Téléphone de contact') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('number', old('number'), ['class'=>
				'form-control',
                                'placeholder'=>'',
                                'id'=>'number'
                                ]) !!}
			</div>
		
	</div>
        <div class="form-group  accordion-inner">
		  {!! Form::label('* Fax') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('number', old('number'), [
                                'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'number'
                                ]) !!}

			</div>
		
	</div>
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Mobile') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  {!! Form::text('number', old('number'), [
                                  'class'=>'form-control',
                                  'placeholder'=>'',
                                  'id'=> 'number'
                                  ]) !!}
			</div>
	</div>           
      </div>
    </div>
<div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#three">
        <h5>www</h5>
      </a>
    </div>
    <div id="three" class="collapse">
      <div class="accordion-inner">
          
	<div class="accordion-inner">
		  {!! Form::label('* e-mail') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>  
                {!! Form::text('email', old('email'), [
               'class'=>'form-control', 
               'placeholder'=>''
                ]) !!}
			</div>
		
	</div>          
          
	<div class="accordion-inner">
		  {!! Form::label('* Site web de l établissement') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>  
                {!! Form::text('site_url', old('site_url'), ['class'=>
		'form-control', 'placeholder'=>
		'Enter Message']) !!}
			</div>
		
	</div>    
          
      </div>
    </div>
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#fourth">
        <h5>Types de cuisines</h5>
      </a>
    </div>
    <div id="fourth" class="collapse">
      <div class="form-group  accordion-inner">

        <section class="container-fluid">
           <div>
               <select id="leftValues" size="5" multiple>
                   
               </select>
           </div>
           <div>
               <input type="button" id="btnRight" value="&gt;&gt;"/>
               <input type="button" id="btnLeft" value="&lt;&lt;"/>
           </div>
           <div>
               <select id="rightValues" size="4" multiple>
                   <option>Régional</option>
                   <option>Végétarienne</option>
                   <option>Grillade aux feu de bois</option>
               </select>
               <div>
                   <input type="text" id="txtRight" />
               </div>
           </div>
       </section>   
          
      </div>
    </div>

    <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#five">
            <h5>Spécialité</h5>
          </a>
    </div>
    <div id="five" class="collapse">
      <div class="accordion-inner">
	<div class="form-group  accordion-inner">
		  {!! Form::label('* Vous pouvez enregistrer jusqu\'a 5 spécialité') !!}
		
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  {!! Form::text('postal_code', old('postal_code'), [
                                  'class'=>'form-control', 
                                'placeholder'=>'',
                                'id'=>'postal_code'
                                ]) !!}<input type="button" class="btn" id="btnLeft" value="Enregistrer"/>
			</div>
		
	</div>
      </div>
    </div>  
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#sixth">
        <h5>Description détaillé</h5>
      </a>
    </div>
    <div id="sixth" class="collapse">
      <div class="accordion-inner">
	<div class="form-group  accordion-inner">
		  {!! Form::label('Description :') !!}
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				{!! Form::textarea('description', old('description'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}  
			</div>
	</div>
      </div>
    </div>  
      
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#seven">
        <h5>Services</h5>
      </a>
    </div>
    <div id="seven" class="collapse">
     <div class="accordion-inner">
	
        <section class="container-fluid">
           <div>
               <select id="leftValues" size="5" multiple>
                   
               </select>
           </div>
           <div>
               <input type="button" id="btnLeft" value="&lt;&lt;"/>
               <input type="button" id="btnRight" value="&gt;&gt;"/>
           </div>
           <div>
               <select id="rightValues" size="4" multiple>
                   <option>Poulet Masala</option>
                   <option>Pizza</option>
                   <option>Fondue</option>
               </select>
               <div>
                   <input type="text" id="txtRight" />
               </div>
           </div>
       </section>          
    </div> 
         
      </div>
    </div>  
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionid" href="index.html#eight">
        <h5>Cardre & Ambiance</h5>
      </a>
    </div>
    <div id="eight" class="collapse">
      <div class="accordion-inner">
	<div class="form-group  accordion-inner">
		  {!! Form::label('Description :') !!}
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				{!! Form::textarea('description', old('description'), ['class'=>
				'form-control', 'placeholder'=>
				'Enter Name']) !!}  
			</div>
	</div>
      </div>
    </div>  
      
  </div>
</div>
     

	<!-- Text input for gender
        <div class="form-group">
		{!! Form::radio('title', 'Société') !!}{!! Form::label('Société') !!}{!!Form::radio('title', 'Madamme') !!}{!! Form::label('Madame') !!}{!!Form::radio('title', 'Monsieur') !!}{!! Form::label('Monsieur') !!}
	</div>
        -->

<nav>
   	<!-- Button -->
	<div class="form-group col-md-44">
		<label class="col-md-44 control-label"></label>
		<div class="col-md-44">
			<button type="submit" class="btn" >Suivant <span class=""></span></button>
		</div>
	</div> 
    
</nav>
               
</div>
   <!-- /.container -->

	{!! Form::close() !!}

@endsection




<script>
function getCoords() {

    var city = $('#city').val();
    var street = $('#street').val();
    var street_number = $('#street_number').val();
    var postal_code = $('#postal_code').val();
    var lat,lng;

    var geocoder = new google.maps.Geocoder();
    address = street + ' ' + street_number + ', ' + postal_code + ' ' + city;

    if (address !== '') {
        // Llamamos a la función geodecode pasandole la dirección que hemos introducido en la caja de texto.
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
                // On affiche les données récuperer par l'addresse
                $('#lat').val(lat);
                $('#lng').val(lng);
                //reverse geocoder
                geocodeLatLng(geocoder, lat, lng);
            }
        });
    }
}


function geocodeLatLng(geocoder, lat, lng) {
    var adresse;
    var latlng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
    };
    geocoder.geocode({
        'location': latlng
    }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                //todo

                var result = results[0];
                //look for locality tag and administrative_area_level_1
                var city, street_number, street, country, postal_code;

                for (var i = 0, len = result.address_components.length; i < len; i++) {
                    var ac = result.address_components[i];
                    if (ac.types.indexOf("locality") >= 0) city = ac.long_name;
                    if (ac.types.indexOf("street_number") >= 0) street_number = ac.long_name;
                    if (ac.types.indexOf("route") >= 0) street = ac.long_name;
                    if (ac.types.indexOf("country") >= 0) country = ac.long_name;
                    if (ac.types.indexOf("postal_code") >= 0) postal_code = ac.long_name;
                }
                //  alert(city+country+street+street_number);
                //on remplie les champs addresse avec les variable google 
                $('#street').val(street);
                $('#street_number').val(street_number);
                $('#city').val(city);
                $('#country').val(country);
                $('#postal_code').val(postal_code);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
    
        $("#btnLeft").click(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#leftValues").append(selectedItem);
        });

        $("#btnRight").click(function () {
            var selectedItem = $("#leftValues option:selected");
            $("#rightValues").append(selectedItem);
        });

        $("#rightValues").change(function () {
            var selectedItem = $("#rightValues option:selected");
            $("#txtRight").val(selectedItem.text());
        });
    
}
      
              function previewImage(input) {
                var preview = document.getElementById('preview');
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                    preview.setAttribute('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
                } else {
                  preview.setAttribute('src', 'placeholder.png');
                }
              }
            


</script>
<style type="text/css">    
  
    #logo{
        font-size: 30px;
        height: 40px;
        width: 100%;
    }    
 
.heading{
    background-color:#fff;
    height: 160px;  
    width: 100%;
}    
    
.accordion-heading
{
    background-color:#848484;
    height: 40px;
}
.accordion-heading:hover
{
    background-color:#000;
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
}
.accordion-heading > a
{
    color:#FFF; 
    text-decoration:none; 
    text-transform:uppercase;
}
SELECT, INPUT[type="text"] {
    width: 160px;
    box-sizing: border-box;
}
SECTION {
    padding: 8px;
    background-color: #f0f0f0;
    overflow: auto;
}
SECTION > DIV {
    float: left;
    padding: 4px;
}
SECTION > DIV + DIV {
    width: 40px;
    text-align: center;
}

</style>
<link rel="stylesheet" href="/css/bootstrap.min.css" />
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script> 
<script src="/js/bootstrap.min.js"></script>
@section('js_imports_footer')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKK5Lh46iA_fwTsblMioJyfU04-K8JUCo&libraries=places" type="text/javascript"></script>
@endsection