<section class="tile">
    <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font">{{ $title }}</h1>
        <ul class="controls">
            <li>
                <a role="button" tabindex="0" class="pickDate">
                    <span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                </a>
            </li>
            <li class="dropdown">

                <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                    <i class="fa fa-spinner fa-spin"></i>
                </a>

                <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                    <li>
                        <a role="button" tabindex="0" class="tile-toggle">
                            <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                            <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                        </a>
                    </li>
                    <!--
                    <li>
                        <a role="button" tabindex="0" class="tile-refresh">
                            <i class="fa fa-refresh"></i> Refresh
                        </a>
                    </li>
                    -->
                    <li>
                        <a role="button" tabindex="0" class="tile-fullscreen">
                            <i class="fa fa-expand"></i> Fullscreen
                        </a>
                    </li>
                </ul>

            </li>
            @if(!empty($add_href))
            <li class="add"><a role="button" tabindex="0" class="tile-add" href='{{ $add_href }}'><i class="fa fa-plus"></i></a></li>
            @endif
        </ul>
    </div>
    <!--
    <td>
        <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 150px; margin-right: 5px">
            <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%;"></div>
        </div>
        <small>42%</small>
    </td>
    -->
    <div class="tile-body datatable-container">

        @component('components.datatable', ['tabledata' => $tabledata])

        @endcomponent
        
    </div>
</section>