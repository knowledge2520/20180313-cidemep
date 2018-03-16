<div class="box-body">
    <div class=" form-group col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.email')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="email" value="{{ $patient->email }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('full_name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.name')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="full_name" value="{{$patient->profile->full_name }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('full_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.phone')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="phone" value="{{ $patient->profile->phone }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.address')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="address" value="{{ $patient->profile->address }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('gender') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.gender')}}</label>
        <div class="col-sm-2 col-xs-12 ">
            <select class="form-control" name="gender">
                    <option value="Male">{{trans('pemedic::patients.table.male')}}</option>
                    <option value="Female" {{ ($patient->profile->gender == 'Female')?"selected":"" }}>{{trans('pemedic::patients.table.female')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('dob') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.dob')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="dob" name="dob" value="{{ !empty($patient->profile->dob)?date('m/d/Y',strtotime($patient->profile->dob)):$patient->profile->dob }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('height') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.height')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="height" value="{{ $patient->profile->height }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('height', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('weight') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.weight')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="weight" value="{{ $patient->profile->weight }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('weight', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.type')}}</label>
        <div class="col-sm-2 col-xs-12 ">
            <select class="form-control" name="type">
                    <option value="Normal">{{trans('pemedic::patients.table.normal')}}</option>
                    <option value="Vip" {{ ($patient->profile->type == 'Vip')?"selected":"" }} >{{trans('pemedic::patients.table.vip')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
     <div class=" form-group col-sm-12 {{ $errors->has('height') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.other_info')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <textarea type="text" class="form-control" name="other_info">{{ $patient->profile->other_info }}</textarea>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('other_info', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    
    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.clinic')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control select2" name="clinic_id[]" multiple="multiple">
                    <option value="">Select Clinic</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->user->id }}" 
                            <?php 
                                $clinic_users =  $patient->clinic()->get();
                            ?>
                            @if(count($clinic_users)>0)
                                @foreach ($clinic_users as  $clinic_user) 
                                    @if($clinic->user->id == $clinic_user->id)
                                        selected
                                    @endif
                                @endforeach
                            @endif 
                            
                            >{{ $clinic->clinic_name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    @if(!empty($patient->profile->image))
    <div class="form-group col-sm-12 col-xs-12 curent_image">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.current')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $patient->profile->image }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink" href="#" img-id="{{$patient->profile->id}}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
                <input name="deals_remove" id="dealRemove" value="" type="hidden">
            </div>
        </div>
    </div>
    @endif
    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.image')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" id="image-file" name="image" onchange="loadFile(event)" />
            <span class="help-block">
                <strong id="file-size-error" class="text-danger"></strong>
            </span>
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <img id="output" style="height: 200px; width: auto;"/>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="hidden theurl">{{ URL::route('admin.patient.patient.deleteImage') }}</div>

<script type="text/javascript">
    $( document ).ready(function() {
        $('#dob').datepicker({
        });
        $('.select2').select2();
    });
</script>
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
            var patient_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'patient_id':patient_id},
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