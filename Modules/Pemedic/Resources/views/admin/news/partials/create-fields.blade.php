<div class="box-body">
    <div class="box-body">
        <div class='form-group{{ $errors->has("{$lang}.title") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[title]", trans('page::pages.form.title')) !!}
            {!! Form::text("{$lang}[title]", old("{$lang}.title"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('page::pages.form.title')]) !!}
            {!! $errors->first("{$lang}.title", '<span class="help-block">:message</span>') !!}
        </div>
        @editor('content', trans('page::pages.form.body'), old("{$lang}.content"), $lang)
        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
            {!! Form::label("{$lang}[image]", trans('pemedic::doctors.table.image')) !!}
            <div class="" >
                <input type="file" name="{{$lang}}[image]" onchange="loadFile(event,'<?= $lang ?>')" />
            </div>
            <div id="preview-pane">
                <label class="control-label">{{trans('pemedic::doctors.table.preview')}}</label>
                <div class="">
                    <img id="{{$lang}}-output" style="height: 200px; width: auto;"/>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 " >
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
