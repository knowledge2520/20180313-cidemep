<div class="box-body">
    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.clinic')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control" name="clinic_id">
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->user_id }}" {{ ($voucher->clinic_id == $clinic->user_id)?"selected":"" }}>{{ $clinic->clinic_name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.name')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="name" value="{{ $voucher->name }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('start_date') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.start date')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="start_date" name="start_date" value="{{ date('m/d/Y',strtotime($voucher->start_date)) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class=" form-group col-sm-12 {{ $errors->has('expiry_date') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.end date')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" value="{{ date('m/d/Y',strtotime($voucher->expiry_date)) }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('expiry_date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    @if(!empty($voucher->image))
    <div class="form-group col-sm-12 col-xs-12 curent_image">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.current')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $voucher->image }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink" href="#" img-id="{{$voucher->id}}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
            </div>
        </div>
    </div>
    @endif
    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.image')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" id="image-file" name="image" onchange="loadFile(event)" />
            <span class="help-block">
                <strong id="file-size-error" class="text-danger"></strong>
            </span>
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::vouchers.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <img id="output" style="height: 200px; width: auto;"/>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="hidden theurl">{{ URL::route('admin.voucher.voucher.deleteImage') }}</div>

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

    $( document ).ready(function() {
        $('#start_date').datepicker({
        });
        $('#expiry_date').datepicker({
        });
    });
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink').click( function() {
            var voucher_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'voucher_id':voucher_id},
                success:function(data){
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