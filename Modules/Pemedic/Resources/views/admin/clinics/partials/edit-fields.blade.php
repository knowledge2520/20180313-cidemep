<div class="box-body">
    <div class=" form-group col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.email')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="email" value="{{ $clinic->user->email }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('clinic_name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.name')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="clinic_name" value="{{ $clinic->clinic_name }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('clinic_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.phone')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="phone" value="{{ $clinic->phone }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('vip_phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.vip phone')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="vip_phone" value="{{ $clinic->vip_phone }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('vip_phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.address')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="address" value="{{ $clinic->address }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('map') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.map')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="map" value="{{ $clinic->map }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('map', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('word_time') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.work time')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="word_time" value="{{ $clinic->word_time }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('word_time', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('website') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.website')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="website" value="{{ $clinic->website }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('issurance') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.issurance')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="issurance" value="{{ $clinic->issurance }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('issurance', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('status') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.status')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="radio" name="completed" value="0" {{ $clinic->user->isActivated()==false?"checked":"" }}> InActive<br>
            <input type="radio" name="completed" value="1" {{ $clinic->user->isActivated()==true?"checked":"" }}> Active
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    @if(!empty($clinic->image))
    <div class="form-group col-sm-12 col-xs-12 curent_image">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.current')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $clinic->image }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink" href="#" img-id="{{$clinic->id}}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
                <input name="deals_remove" id="dealRemove" value="" type="hidden">
            </div>
        </div>
    </div>
    @endif
    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.image')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" id="image-file" name="image" onchange="loadFile(event)" />
            <span class="help-block">
                <strong id="file-size-error" class="text-danger"></strong>
            </span>
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::clinics.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <img id="output" style="height: 200px; width: auto;"/>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>


</div>
<div class="hidden theurl">{{ URL::route('admin.clinic.clinic.deleteImage') }}</div>
<script type="text/javascript">
    // Change Photo Preview on File upload
    var loadFile = function(event) {
        $("#preview-pane").show();
        var reader = new FileReader();
        reader.onload = function(){
        var output = document.getElementById('output');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink').click( function() {
            var clinic_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'clinic_id':clinic_id},
                success:function(data){
                    console.log(data);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        $('#image-file').bind('change', function() {
            var file_size = this.files[0].size/1024/1024;
            if(file_size >= 2)
            {
                $('#file-size-error').html("The file should not exceed 2MB");
                $('#image-file').val("");
            }
            else
            {
                $('#file-size-error').remove();
            }
        });
    });
</script>