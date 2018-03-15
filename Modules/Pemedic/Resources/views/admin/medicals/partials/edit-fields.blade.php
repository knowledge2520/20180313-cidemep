<div class="box-body">

    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.clinic')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control" id="clinic" name="clinic_id">
                    <option>{{trans('pemedic::medicals.table.clinic select')}}</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->user_id }}" {{ $medical->clinic_id == $clinic->user_id?"selected":"" }} >{{ $clinic->clinic_name }}</option>
                    @endforeach
            </select>
        </div>
    </div>
    
    <div class=" form-group col-sm-12 {{ $errors->has('type') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.patient')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <select class="form-control patient" name="patient_id">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->user_id }}" {{ $medical->patient_id == $patient->user_id?"selected":"" }} >{{ $patient->user->email }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.doctor')}}</label>
        <div class="col-sm-12 col-xs-12 doctor">
            <select class="form-control" name="doctor_id">
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->user_id }}" {{ $medical->doctor_id == $doctor->user_id?"selected":"" }}>{{ $doctor->user->email }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <div class=" form-group col-sm-12 {{ $errors->has('date') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.date')}}</label>
        <div class="col-sm-12 col-xs-12 ">
            <input type="text" class="form-control" id="date" name="date" value="{{ !empty($medical->date)?date('m/d/Y',strtotime($medical->date)):null }}">
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('date', '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    @if(count($medical->file)>0)
        @foreach($medical->file as $file)
            <?php 
                $type = substr($file->path,-3);
            ?>
            @if($type == 'pdf')
                <div class="form-group col-sm-4 col-xs-12 curent_image-{{ $file->id }}">
                    <label class="col-sm-12 col-xs-12 control-label ">{{ $file->thumbnail }}</label>
                    <div class="col-sm-12 col-xs-12 " >
                        <div class="jsThumbnailImageWrapper" >
                            <figure class="ui-sortable-handle">
                                <img src="/assets/media/pdf.png" alt="" style="width:100px;height:100px">
                                <a class="jsRemoveLink" href="#" img-id="{{ $file->id }}">
                                    <i class="fa fa-times-circle removeIcon"></i>
                                </a>
                            </figure>
                            <input name="deals_remove" id="dealRemove" value="" type="hidden">
                        </div>
                    </div>
                    <label class="col-sm-12 col-xs-12 control-label "><a href="{{ $file->path }}">{{trans('pemedic::medicals.table.download file')}}</a></label>
                </div>
            @else
                <div class="form-group col-sm-4 col-xs-12 curent_image-{{ $file->id }}">
                    <label class="col-sm-12 col-xs-12 control-label ">{{ $file->thumbnail }}</label>
                    <div class="col-sm-12 col-xs-12 " >
                        <div class="jsThumbnailImageWrapper" >
                            <figure class="ui-sortable-handle">
                                <img src="{{ $file->path }}" alt="" style="width:100px;height:100px">
                                <a class="jsRemoveLink" href="#" img-id="{{ $file->id }}">
                                    <i class="fa fa-times-circle removeIcon"></i>
                                </a>
                            </figure>
                            <input name="deals_remove" id="dealRemove" value="" type="hidden">
                        </div>
                    </div>
                    <label class="col-sm-12 col-xs-12 control-label "><a href="{{ $file->path }}">{{trans('pemedic::medicals.table.download file')}}</a></label>
                </div>
            @endif
        @endforeach
    @endif

    <div class="form-group col-sm-12 {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.medical')}}</label>
        <div class="col-sm-12 col-xs-12 " >
            <input type="file" name="file[]" multiple id="fileUpload" />
        </div>
        <div id="preview-pane">
            <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.preview')}}</label>
            <div class="col-sm-12 col-xs-12">
                <div id="image-holder" style="height: 100px; width: auto;"></div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 " >
            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>

<div class="hidden theurl">{{ URL::route('admin.medical.medical.deletefile') }}</div>
<div class="hidden theurl-ajax">{{ URL::route('admin.medical.ajax.getData') }}</div>

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

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('.jsRemoveLink').click( function() {
            var file_id     = $(this).attr("img-id");
            $(".curent_image-"+file_id).remove();
            $.ajax({
                type : 'GET',
                url : $('.theurl').text(),
                data : {'file_id':file_id},
                success:function(data){
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        var base_url = window.location.origin;
        $('#clinic').change( function() {
            var clinic_id     = $(this).val();
            $.ajax({
                type : 'GET',
                url : $('.theurl-ajax').text(),
                data : {'clinic_id':clinic_id},
                success:function(data){
                    
                    var html = '<select class="form-control" name="patient_id">';
                    var html_doctor = '<select class="form-control" name="doctor_id">';
                    for (i = 0; i < data.patient.length; i++) { 
                        html +='<option value="'+data.patient[i].user_id +'">'+data.patient[i].full_name+'</option>';                        
                    }
                    html += '</select>';

                    for (i = 0; i < data.doctor.length; i++) { 
                        html_doctor +='<option value="'+data.doctor[i].user_id +'">'+data.doctor[i].full_name+'</option>';                        
                    }
                    html_doctor += '</select>';
                    $(".patient").html(html);
                    $(".doctor").html(html_doctor);
                }
            });
        });
    });
</script>