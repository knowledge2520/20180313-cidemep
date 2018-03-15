<div class="box-body">
    @if(Session::has('email_error'))
        <div class="form-group col-sm-12 alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('email_error') }}
        </div>
    @endif
    <div class=" form-group col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.email')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('full_name') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.name')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('full_name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.phone')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.address')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
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
                    <option value="Female">{{trans('pemedic::patients.table.female')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('dob') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.dob')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('height') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.height')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="height" value="{{ old('height') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('height', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('weight') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.weight')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" name="weight" value="{{ old('weight') }}">
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
                    <option value="Vip">{{trans('pemedic::patients.table.vip')}}</option>
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
     <div class=" form-group col-sm-12 {{ $errors->has('height') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.other_info')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <textarea type="text" class="form-control" name="other_info">{{ old('other_info') }}</textarea>
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
                        <option value="{{ $clinic->user_id }}" {{ $request->has('clinic_id') && $request->clinic_id == $clinic->user_id ? 'selected=selected': '' }} >{{ $clinic->clinic_name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::patients.table.image')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" name="image" multiple onchange="loadFile(event)" />
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