<!------------- RESTAURANT GALLERIES -------------------------------------->
@if(checkFlow($data, ['galleries']))
<section class="container-fluid ets-galleries">
    <div class="section-bg"></div>
    <div class="container">
        <h1><strong>Galeries</strong> photos</h1>
        <div class="row gallery-box">
            @foreach($data['galleries'] as $galleryData)
                @foreach($galleryData['medias'] as $mediaPath)
                    @if($loop->first)
                    <a class="col-xs-12 col-sm-6 gallery-item" href="{{ $mediaPath }}">
                        <div class="square-container">
                            <div class="crop">
                                <img src="{{ $mediaPath }}" alt="{{ $galleryData['name'] }} gallery"/>
                            </div>
                        </div>
                        <div class="gallery-details">
                            <div class="gallery-title">
                                {{ $galleryData['name'] }}
                            </div>
                            <div class="gallery-info">
                                ({{ $galleryData['nb_media'].' '.__('photos') }})
                            </div>
                        </div>
                    </a>
                    @else
                    <a class="gallery-item" href="{{ $mediaPath }}"></a>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endif
<!------------- RESTAURANT LAST PICS -------------------------------------->
@if(checkFlow($data, ['last_pics']))
<section class="container-fluid ets-last-pics">
    <div class="section-bg"></div>
    <div class="container">
        <h1><strong>Dernières</strong> photos</h1>
        <div class="row gallery-box">
            @foreach($data['last_pics'] as $lastPics)
            <a class="col-xs-4 col-sm-2" href="{{ $lastPics['picture'] }}">
                <div class="last-pic-item" style="background-image: url('{{ $lastPics['picture'] }}');">
                <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
                    <!--<img src="{{ $lastPics['picture'] }}" class="last-pic-img" alt="gallery picture"/>-->
                </div>
            </a>                    
            @endforeach
        </div>
    </div>
</section>
@endif