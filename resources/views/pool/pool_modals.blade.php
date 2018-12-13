{{-- Contribute Modal --}}
<div class="modal fade" id="modal_pool_contribute" tabindex="-1" role="dialog" aria-labelledby="contribute">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('common.close') }}"><span
                            aria-hidden="true">&times;</span></button>
                <h2><i class="{{ config('other.font-awesome') }} fa-thumbs-up"></i> {{ trans('pool.add-bon') }}!</h2>
            </div>
            <form role="form" method="POST" action="{{ route('contribute',['id' => $pool->id]) }}">
                @csrf
                <div class="modal-body text-center">
                    <p>{{ trans('pool.enter-bp') }}</p>
                    <fieldset>
                        <input type='hidden' tabindex='3' name='pool_id' value='{{ $pool->id }}'>
                        <input class="form-control" type="number" tabindex="3" name='bonus_points' min='1' value="1">
                        <p>{{ trans('common.anonymous') }} {{ trans('pool.contribution') }}?</p>
                        <div class="radio-inline">
                            <label><input type="radio" name="anon" value="1">{{ trans('common.yes') }}</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="anon" value="0" checked>{{ trans('common.no') }}</label>
                        </div>
                    </fieldset>
                    <br>
                    <div class="btns">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('common.add') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>