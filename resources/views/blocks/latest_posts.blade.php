<div class="col-md-10 col-sm-10 col-md-offset-1">
    <div class="clearfix visible-sm-block"></div>

    {{-- LATEST TOPICS VUE COMPONENT --}}
    <latest-posts :can-read="{{ auth()->user()->can('read_topic') }}"></latest-posts>

</div>
