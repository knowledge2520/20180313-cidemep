@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::patients.title.patients') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::patients.title.patients') }}</li>
    </ol>
@stop

@section('content')
    @if(Session::has('totalSuccess') && Session::get('totalSuccess') > 0)
        <div class="alert alert-success fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('totalSuccess') }} records import successfully.
        </div>
    @endif
    @if(Session::has('dataErrors') && count(Session::get('dataErrors')) > 0)
        <div class="alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @foreach (Session::get('dataErrors') as $error)
                <ul>
                    <li>{{ $error }} import was not successful.</li>
                </ul>
            @endforeach
        </div>
    @endif
    @if(Session::has('formatErrors') && count(Session::get('formatErrors')) > 0)
        <div class="alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @foreach (Session::get('formatErrors') as $msg_error)
                <ul>
                    <li>{{ $msg_error }}</li>
                </ul>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div style="width:200px;float: left;">
                <select id="clinic" class="form-control" style="margin-bottom:5px!important;">
                    <option value="?clinic_id=0">All Clinic</option>
                    <?php if (isset($clinics)): 
                        $clinicId = 'clinic_id='. $request->clinic_id;
                    ?>
                    <?php foreach ($clinics as $clinic): ?>
                        <option {{ $request->has('clinic_id') && $request->clinic_id == $clinic->user_id ? 'selected=selected': '' }} value="?clinic_id={{$clinic->user_id}}">{{$clinic->clinic_name}}</option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.patient.patient.create', [$clinicId]) }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::patients.button.create patient') }}
                    </a>
                    <a href="{{ route('admin.patient.export.index') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px; margin-left:2px;">{{ trans('pemedic::patients.button.exportCsv') }}</a>
                    <a href="#" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-import" style="padding: 4px 10px; margin-left:2px;">{{ trans('pemedic::patients.button.import') }}</a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('pemedic::patients.table.email') }}</th>
                                <th>{{ trans('pemedic::patients.table.name') }}</th>
                                <th>{{ trans('pemedic::patients.table.phone') }}</th>
                                <th>{{ trans('pemedic::patients.table.address') }}</th>
                                <th>{{ trans('pemedic::patients.table.gender') }}</th>
                                <th>{{ trans('pemedic::patients.table.type') }}</th>
                                <th>{{ trans('pemedic::patients.table.status') }}</th>
                                <th data-sortable="false" style="min-width: 75px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($patients)): ?>
                            <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><input type="checkbox" name="patient_id[]" value="{{ $patient->id }}"></td>
                                <td>
                                    <a href="{{ route('admin.patient.patient.edit', [$patient->user_id]) }}">
                                        {{ $patient->user->email }}
                                    </a>
                                </td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ str_limit($patient->address, $limit = 50, $end = '...') }}</td>
                                <td>{{ $patient->gender }}</td>
                                <td>{{ $patient->type }}</td>
                                <td>
                                    @if($patient->user->isActivated())
                                        <span class="label label-primary">{{ trans('pemedic::patients.table.active') }}</span>
                                    @else
                                        <span class="label label-danger">{{ trans('pemedic::patients.table.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.patient.patient.edit', [$patient->user_id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.patient.patient.destroy', [$patient->user_id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
                <div class="box-footer">
                    {!! Form::open(['route' => ['admin.patient.patient.bulkdelete'], 'method' => 'post']) !!}
                        <input type="hidden" id="patient-hidden" name="users" value="">
                        <button class="btn btn-danger pull-left btn-flat"> {{ trans('pemedic::patients.button.bulk delete') }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
    <!-- Modal import patient -->
    <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <!-- Modal content-->
            {!! Form::open(['route' => ['admin.patient.import.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('pemedic::patients.title.import patient') }}</h4>
                </div>
                <div class="form-group col-sm-12">
                    <label>{{ trans('pemedic::patients.form.select file') }}</label>
                    <input type="file" name="file">
                </div>
                <div class="form-group col-sm-12">
                    <p>
                        <a href="/assets/template_import_patient.csv">Click Here</a> to download a sample CSV file.
                    </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-flat pull-left">Create</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('pemedic::patients.title.create patient') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            var base_url = window.location.origin;
            $('#clinic').change(function() {
                clinic = $(this).val();
                location.href = base_url + '/en/backend/pemedic/patients' + clinic;
            });

            var array=[];
            $("input[name^='patient_id']").on("change",function(){
                if($(this).prop('checked') ){
                    array.push($(this).val() )
                }else{
                    array.splice( array.indexOf( $(this).val() ) , 1 ) ;
                }

                $("#patient-hidden").val(array.join(","));
            })
        });
    </script>


    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.patient.patient.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
