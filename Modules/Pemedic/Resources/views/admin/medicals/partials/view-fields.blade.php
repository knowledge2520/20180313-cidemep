<div class="box-body">

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.patient')}}</label>
        <div class="col-sm-12 col-xs-12 patient">
            <input class="form-control" type="text" name="" value="{{ $medical->patient->email }}" disabled>
        </div>
    </div>

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.doctor')}}</label>
        <div class="col-sm-12 col-xs-12 patient">
            <input class="form-control" type="text" name="" value="{{ $medical->doctor_name }}" disabled>
        </div>
    </div>

    <div class=" form-group col-sm-12">
        <label class="col-sm-12 col-xs-12 control-label ">{{trans('pemedic::medicals.table.date')}}</label>
        <div class="col-sm-12 col-xs-12 patient">
            <input class="form-control" type="text" name="" value="{{ $medical->date }}" disabled>
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
                            </figure>
                            <input name="deals_remove" id="dealRemove" value="" type="hidden">
                        </div>
                    </div>
                    <label class="col-sm-12 col-xs-12 control-label "><a href="{{ $file->path }}">{{trans('pemedic::medicals.table.download file')}}</a></label>
                </div>
            @endif
        @endforeach
    @endif
</div>