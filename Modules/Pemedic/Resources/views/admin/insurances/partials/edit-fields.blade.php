<div class="box-body">
    <div class=" form-group col-sm-12 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.name')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="name" value="{{ old('name',$insurance->name) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
     <div class=" form-group col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.phone')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="phone" value="{{ old('phone',$insurance->phone) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('work_time') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.work_time')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="work_time" value="{{ old('work_time',$insurance->work_time) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('work_time', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('website') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.website')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="website" value="{{ old('website',$insurance->website) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.address')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <textarea class="form-control" name="address">{{ old('address',$insurance->address) }}</textarea>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('ordering') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.ordering')}}<span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="ordering" value="{{ old('ordering',$insurance->ordering) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('ordering', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('status') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::insurances.table.status')}}</label>
        <div class="col-xs-12 ">
            <select class="form-control" name="status">
                    <option {{ $insurance->status == 1 ? 'selected' : '' }} value="1">{{trans('pemedic::insurances.table.active')}}</option>
                    <option {{ $insurance->status == 0 ? 'selected' : '' }}  value="0">{{trans('pemedic::insurances.table.inactive')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    @if(!empty($insurance->image))
    <div class="form-group col-sm-12 col-xs-12 curent_image">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.current')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $insurance->image }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink" href="#" img-id="{{$insurance->id}}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
                <input name="deals_remove" id="dealRemove" value="" type="hidden">
            </div>
        </div>
    </div>
    @endif
    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.image')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" name="image" onchange="loadFile(event)" />
            <span class="help-block">
                <strong id="file-size-error" class="text-danger"></strong>
            </span>
        </div>
         <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <img id="output" style="height: 200px; width: auto;"/>
            </div>
        </div>
       
    </div>

</div>
<div class="hidden theurl">{{ URL::route('admin.insurance.insurance.deleteImage') }}</div>
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
    $('#image-file').bind('change', function() {
            var file_size = this.files[0].size/1024/1024;
            if(file_size >= 2)
            {
                $('#file-size-error').html("The file should not exceed 2MB");
                $('#image-file').val("");
            }
        });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink').click( function() {
            var insurance_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'insurance_id':insurance_id},
                success:function(data){
                    console.log(data);
                }
            });
        });
    });
</script>