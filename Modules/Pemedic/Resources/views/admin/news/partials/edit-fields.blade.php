<?php  $item = getDataLocaleNewTranslation($new,$lang) ?>
<div class="box-body">
    <div class="box-body">
        <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[title]", trans('page::pages.form.title')) !!}
            <?php $old = isset($item->title) ? $item->title : '' ?>
            {!! Form::text("{$lang}[title]", old("{$lang}.title", $old), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('page::pages.form.title')]) !!}
            {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
        </div>

        <?php $oldContent = isset($item->content) ? $item->content : '';
              $oldImage = isset($item->image) ? $item->image : '';
              $oldID = isset($item->id) ? $item->id : ''; ?>
        @editor('content', trans('page::pages.form.body'), old("$lang.content", $oldContent), $lang)
        @if(!empty($oldImage))
    <div class="form-group curent_image">
        <label class="control-label ">{{trans('pemedic::doctors.table.current')}}</label>
        <div class="" >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $oldImage }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink-{{$lang}}" href="#" img-id="{{$oldID}}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
                <input name="deals_remove" id="dealRemove" value="" type="hidden">
            </div>
        </div>
    </div>
    @endif
    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="control-label ">{{trans('pemedic::doctors.table.image')}}</label>
        <div class="" >
            <input type="file" name="{{$lang}}[image]" onchange="loadFile(event,'<?= $lang ?>')" />
        </div>
        <div id="preview-pane">
            <label class="control-label ">{{trans('pemedic::doctors.table.preview')}}</label>
            <div class="">
                <img id="{{$lang}}-output" style="height: 200px; width: auto;"/>
            </div>
        </div>
        <div class="">
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    </div>
</div>

<script type="text/javascript">
    // Change Photo Preview on File upload
    var loadFile = function(event,lang)  {
        $("#preview-pane").show();
        var reader = new FileReader();
        reader.onload = function(){
        var output = document.getElementById(lang+'-output');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>
