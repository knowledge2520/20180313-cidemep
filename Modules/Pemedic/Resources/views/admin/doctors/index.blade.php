@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::doctors.title.doctors') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::doctors.title.doctors') }}</li>
    </ol>
@stop

@section('content')
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
                    <a href="{{ route('admin.doctor.doctor.create', [$clinicId]) }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::doctors.button.create doctor') }}
                    </a>
                    <a href="{{ route('admin.doctor.export.index') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px; margin-left:2px;">{{ trans('pemedic::doctors.button.exportCsv') }}</a>
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
                                <th>{{ trans('pemedic::doctors.table.email') }}</th>
                                <th>{{ trans('pemedic::doctors.table.name') }}</th>
                                <th>{{ trans('pemedic::doctors.table.phone') }}</th>
                                <th>{{ trans('pemedic::doctors.table.address') }}</th>
                                <th>{{ trans('pemedic::doctors.table.gender') }}</th>
                                <th>{{ trans('pemedic::doctors.table.type') }}</th>
                                <th>{{ trans('pemedic::doctors.table.image') }}</th>
                                <th>{{ trans('pemedic::doctors.table.status') }}</th>
                                <th data-sortable="false" style="min-width: 75px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                            <tr>
                                <td><input type="checkbox" name="doctor_id[]" value="{{ $doctor->id }}"></td>
                                <td>
                                    <a href="{{ route('admin.doctor.doctor.edit', [$doctor->user_id]) }}">
                                        {{ $doctor->user->email }}
                                    </a>
                                </td>
                                <td>{{ $doctor->full_name }}</td>
                                <td>{{ $doctor->phone }}</td>
                                <td>{{ str_limit($doctor->address, $limit = 50, $end = '...') }}</td>
                                <td>{{ $doctor->gender }}</td>
                                <td>
                                    @if($doctor->is_support==0)
                                        {{ trans('pemedic::doctors.table.doctor') }}
                                    @else
                                        {{ trans('pemedic::doctors.table.support') }}
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        @if(!empty($doctor->image))
                                            <img src="{{ $doctor->image }}" alt="" style="width:150px">
                                        @endif
                                    </center>
                                </td>
                                <td>
                                    @if($doctor->user->isActivated())
                                        <span class="label label-primary">{{ trans('pemedic::doctors.table.active') }}</span>
                                    @else
                                        <span class="label label-danger">{{ trans('pemedic::doctors.table.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.doctor.doctor.edit', [$doctor->user_id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.doctor.doctor.destroy', [$doctor->user_id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>{{ trans('pemedic::doctors.table.email') }}</th>
                                <th>{{ trans('pemedic::doctors.table.name') }}</th>
                                <th>{{ trans('pemedic::doctors.table.phone') }}</th>
                                <th>{{ trans('pemedic::doctors.table.address') }}</th>
                                <th>{{ trans('pemedic::doctors.table.gender') }}</th>
                                <th>{{ trans('pemedic::doctors.table.type') }}</th>
                                <th>{{ trans('pemedic::doctors.table.image') }}</th>
                                <th>{{ trans('pemedic::doctors.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
                <div class="box-footer">
                    {!! Form::open(['route' => ['admin.doctor.doctor.bulkdelete'], 'method' => 'post']) !!}
                        <input type="hidden" id="doctor-hidden" name="users" value="">
                        <button class="btn btn-danger pull-left btn-flat"> {{ trans('pemedic::patients.button.bulk delete') }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('pemedic::doctors.title.create doctor') }}</dd>
    </dl>
@stop

@push('js-stack')
    
    <script type="text/javascript">
        $( document ).ready(function() {
            var base_url = window.location.origin;
            $('#clinic').change(function() {
                $clinic = $(this).val();
                location.href = base_url + '/en/backend/pemedic/doctors' + $clinic;
            });

            var array=[];
            $("input[name^='doctor_id']").on("change",function(){
                if($(this).prop('checked') ){
                    array.push($(this).val() )
                }else{
                    array.splice( array.indexOf( $(this).val() ) , 1 ) ;
                }

                $("#doctor-hidden").val(array.join(","));
            })
        });
    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.doctor.doctor.create') ?>" }
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
