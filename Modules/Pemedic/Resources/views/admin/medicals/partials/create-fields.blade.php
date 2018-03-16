<div class="box-body">
    @if(Session::has('patient_error'))
        <div class="form-group col-sm-12 alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('patient_error') }}
        </div>
    @endif
    <div class="form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.type')}}</label>
        <div class="col-sm-12 col-xs-12 patient">
           <select class="form-control" name="patient_group" id="type">
                    <option value="1">{{trans('pemedic::medicals.table.patient')}}</option>
                    <option value="2">{{trans('pemedic::medicals.table.group')}}</option>
            </select>
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('patient_id') ? ' has-error' : '' }}" id="patient">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.patient')}}</label>
        <div class="col-sm-12 col-xs-12">
           <select class="form-control select2" name="patient_id">
                    <option value="">{{trans('pemedic::medicals.table.patient select')}}</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->user_id }}" >{{ $patient->user->email }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('patient_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('patient_id') ? ' has-error' : '' }}" id="group">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.group')}}</label>
        <div class="col-sm-12 col-xs-12">
           <select class="form-control select2" name="group_id">
                    <option value="">{{trans('pemedic::medicals.table.group select')}}</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" >{{ $group->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('patient_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.doctor')}}</label>
        <div class="col-sm-12 col-xs-12 doctor">
            <select class="form-control select2" name="doctor_id" id="doctor_id">
                    <option value="">{{trans('pemedic::medicals.table.doctor select')}}</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->user_id }}" >{{ $doctor->user->email }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('date') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.date')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="date" name="date" value="{{ old('date') }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.medical')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" name="file[]" multiple onchange="loadFile(event)" />
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

<div class="hidden theurl">{{ URL::route('admin.medical.ajax.getData') }}</div>

<script type="text/javascript">
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
        $('#date').datepicker({
        });
        $('.select2').select2();
    });
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $("#group").hide();
        $('#type').change( function() {
            var type     = $(this).val();
            if(type==1)
            {
                $("#group").hide();
                $("#patient").show();
            }
            else
            {
                $("#group").show();
                $("#patient").hide();
            }
        });
    });
</script>