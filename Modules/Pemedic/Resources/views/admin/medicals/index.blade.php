@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::medicals.title.medicals') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::medicals.title.medicals') }}</li>
    </ol>
@stop

@section('content')
    @if(Session::has('patient_error') && count(Session::get('patient_error')) > 0)
        <div class="alert alert-error fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @foreach (Session::get('patient_error') as $error)
                <ul>
                    <li>{{ $error }} import was not successful.</li>
                </ul>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.medical.medical.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::medicals.button.create medical') }}
                    </a>
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
                                <th style="width:15px">{{ trans('pemedic::medicals.table.id') }}</th>
                                <th>{{ trans('pemedic::medicals.table.patient') }}</th>
                                <th>{{ trans('pemedic::medicals.table.email') }}</th>
                                <th>{{ trans('pemedic::medicals.table.doctor') }}</th>
                                <th>{{ trans('pemedic::medicals.table.date') }}</th>
                                <th>{{ trans('pemedic::medicals.table.status') }}</th>
                                <th data-sortable="false" style="min-width: 75px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($medicals)): ?>
                            <?php foreach ($medicals as $medical): ?>
                            <tr>
                                <td><input type="checkbox" name="medical_id[]" value="{{ $medical->id }}"></td>
                                <td>{{ $medical->id }}</td>
                                <td>{{ $medical->patient->profile->full_name }}</td>
                                <td>{{ $medical->patient->email }}</td>
                                <td>
                                    @if(!empty($medical->doctor_id))
                                    {{ $medical->doctor->profile->full_name }}
                                    @endif
                                </td>
                                <td>{{ $medical->date }}</td>
                                <td>
                                    @if(empty($medical->clinic_id))
                                        <span class="label label-primary">{{ trans('pemedic::medicals.table.create local') }}</span>
                                    @else
                                        <span class="label label-success">{{ trans('pemedic::medicals.table.create clinic') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.medical.medical.edit', [$medical->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.medical.medical.destroy', [$medical->id]) }}"><i class="fa fa-trash"></i></button>
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
                    {!! Form::open(['route' => ['admin.medical.medical.bulkdelete'], 'method' => 'post']) !!}
                        <input type="hidden" id="medical-hidden" name="medicals" value="">
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
        <dd>{{ trans('pemedic::medicals.title.create medical') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            var base_url = window.location.origin;
            $('#clinic').change(function() {
                clinic = $(this).val();
                location.href = base_url + '/en/backend/pemedic/medicals' + clinic;
            });

            var array=[];
            $("input[name^='medical_id']").on("change",function(){
                if($(this).prop('checked') ){
                    array.push($(this).val() )
                }else{
                    array.splice( array.indexOf( $(this).val() ) , 1 ) ;
                }
                $("#medical-hidden").val(array.join(","));
            })
        });
    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.medical.medical.create') ?>" }
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
