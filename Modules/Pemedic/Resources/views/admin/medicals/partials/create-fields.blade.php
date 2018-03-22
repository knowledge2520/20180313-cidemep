<div class="box-body">
    @if(Session::has('patient_error'))
        <div class="form-group col-sm-12 alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('patient_error') }}
        </div>
    @endif
    <div class=" form-group col-sm-12 {{ $errors->has('clinic_id') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.clinic')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control" name="clinic_id" id="clinic">
                    <option value="">{{trans('pemedic::medicals.table.clinic select')}}</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->user_id }}" >{{ $clinic->clinic_name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('clinic_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.type')}}</label>
        <div class="col-sm-12 col-xs-12">
           <select class="form-control" name="patient_group" id="type">
                    <option value="1">{{trans('pemedic::medicals.table.patient')}}</option>
                    <option value="2">{{trans('pemedic::medicals.table.group')}}</option>
            </select>
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('patient_id') ? ' has-error' : '' }}" id="patient">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.patient')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 patient">
           
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('patient_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="form-group col-sm-12 {{ $errors->has('group_id') ? ' has-error' : '' }}" id="group">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.group')}} <span class="text-danger"> (*) </span></label>
        <div class="col-sm-12 col-xs-12 group">
           
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('group_id', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.doctor')}}</label>
        <div class="col-sm-12 col-xs-12 doctor">
            
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
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $("#group").hide();
        $("#doctor").hide();
        $('#clinic').change( function() {
            var clinic_id     = $(this).val();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'clinic_id':clinic_id},
                success:function(data){
                    var html = '<select class="form-control select2" id="patient_change" name="patient_id">';
                    var html_doctor = '<select class="form-control select2" name="doctor_id">';
                    var html_group = '<select class="form-control" name="group_id">';
                    for (i = 0; i < data.patient.length; i++) { 
                        html +='<option value="'+data.patient[i].user_id +'">'+data.patient[i].email+'</option>';                        
                    }
                    html += '</select>';

                    for (i = 0; i < data.doctor.length; i++) { 
                        html_doctor +='<option value="'+data.doctor[i].user_id +'">'+data.doctor[i].email+'</option>';                        
                    }
                    html_doctor += '</select>';

                    for (i = 0; i < data.group.length; i++) { 
                        html_group +='<option value="'+data.group[i].id +'">'+data.group[i].name+'</option>';                        
                    }
                    html_group += '</select>';

                    $(".patient").html(html);
                    $(".doctor").html(html_doctor);
                    $(".group").html(html_group);
                    $('.select2').select2();
                }
            });
        });
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
    });
</script>