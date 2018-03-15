@extends('layouts.master')
@section('styles')
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
@stop

@section('content-header')
    <h1>
        {{ trans('pemedic::news.title.edit new') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.new.new.index') }}">{{ trans('pemedic::news.title.news') }}</a></li>
        <li class="active">{{ trans('pemedic::news.title.edit new') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' =>['admin.new.new.update', $new->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('pemedic::admin.news.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.new.new.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
    <div class="hidden theurl">{{ URL::route('admin.new.new.deleteImage') }}</div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@section('scripts')
   <script type="text/javascript" src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.new.new.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink-vi').click( function() {
            var translate_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'translate_id':translate_id},
                success:function(data){
                    console.log(data);
                }
            });
        });
        $('.jsRemoveLink-en').click( function() {
            var translate_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'translate_id':translate_id},
                success:function(data){
                    console.log(data);
                }
            });
        });
    });
    </script>
@endpush
