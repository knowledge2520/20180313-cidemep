<div class="box-body">
    <div class=" form-group col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.email')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="email" value="{{ $doctor->email }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('full_name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.name')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="full_name" value="{{ $doctor->profile->full_name }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('full_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.phone')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="phone" value="{{ $doctor->profile->phone }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.address')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="address" value="{{ $doctor->profile->address }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('gender') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.gender')}}</label>
        <div class="col-sm-2 col-xs-12 ">
            <select class="form-control" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female" {{ ($doctor->profile->gender == 'Female')?"selected":"" }}>Female</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('dob') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.dob')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="dob" name="dob" value="{{ !empty($doctor->profile->dob)?date('m/d/Y',strtotime($doctor->profile->dob)):$doctor->profile->dob }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('is_support') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.type')}}</label>
        <div class="col-sm-2 col-xs-12 ">
            <select class="form-control" name="is_support">
                    <option value="0">Doctor</option>
                    <option value="1" {{ ($doctor->profile->is_support == 'Female')?"selected":"" }}>Support</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('is_support', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('height') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.other_info')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <textarea type="text" class="form-control" name="other_info">{{ $doctor->profile->other_info }}</textarea>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('other_info', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.clinic')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control select2" name="clinic_id[]" multiple="multiple">
                    <option value="">Select Clinic</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->user->id }}" 
                            <?php 
                                $clinic_users =  $doctor->clinic()->get();
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

    @if(!empty($doctor->profile->image))
    <div class="form-group col-sm-12 col-xs-12 curent_image">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.current')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <div class="jsThumbnailImageWrapper" >
                <figure class="ui-sortable-handle">
                    <img src="{{ $doctor->profile->image }}" alt="" style="width:100px;height:100px">
                    <a class="jsRemoveLink" href="#" img-id="{{$doctor->profile->id}}">
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
            <input type="file" name="image" multiple onchange="loadFile(event)" />
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::doctors.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <img id="output" style="height: 200px; width: auto;"/>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

</div>
<div class="hidden theurl">{{ URL::route('admin.doctor.doctor.deleteImage') }}</div>

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
        $('#dob').datepicker({
        });
        $('.select2').select2();
    });
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink').click( function() {
            var doctor_id     = $(this).attr("img-id");
            $(".jsThumbnailImageWrapper").remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'doctor_id':doctor_id},
                success:function(data){
                    console.log(data);
                }
            });
        });
    });
</script>