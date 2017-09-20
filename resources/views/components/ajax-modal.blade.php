<div id="ajax-modal-sample" class="modal fade ajax-modal" role="dialog">
   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    @if(isset($title))
                    {!! $title !!}
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-inner-body">
                    
                </div>
                <div class="progress loading-bar">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      <!--<span class="sr-only">-->Chargement en cours...<!--</span>-->
                    </div>
                </div>
                <div class="modal-errors">
                    
                </div>
            </div>
            <div class="modal-footer">
                @if(isset($footer))
                {!! $footer !!}
                @endif
            </div>
        </div>
   </div>
</div>