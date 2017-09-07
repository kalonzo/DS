<div class="container-fluid">
    <div class="row gallery-box">
        @foreach($medias as $media)
        <a class="col-xs-4 col-sm-2" href="{{ asset($media->getLocalPath()) }}">
            <div class="gallery-box-item" style="background-image: url('{{ asset($media->getLocalPath()) }}');">
                <img src="/img/square-pattern.png" alt="square pattern" class="square-pattern"/>
            </div>
        </a>                    
        @endforeach
    </div>
</div>