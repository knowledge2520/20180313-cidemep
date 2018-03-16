@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::vouchers.title.vouchers') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::vouchers.title.vouchers') }}</li>
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
                    <a href="{{ route('admin.voucher.voucher.create',[$clinicId]) }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::vouchers.button.create voucher') }}
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
                                <th>{{ trans('pemedic::vouchers.table.clinic') }}</th>
                                <th>{{ trans('pemedic::vouchers.table.name') }}</th>
                                <th>{{ trans('pemedic::vouchers.table.start date') }}</th>
                                <th>{{ trans('pemedic::vouchers.table.end date') }}</th>
                                <th data-sortable="false" style="width: 125px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($vouchers)): ?>
                            <?php foreach ($vouchers as $voucher): ?>
                            <tr>
                                <td>{{ $voucher->clinic->clinicProfile->clinic_name }}</td>
                                <td>{{ $voucher->name }}</td>
                                <td>{{ $voucher->start_date }}</td>
                                <td>{{ $voucher->expiry_date }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.voucher.voucher.view', [$voucher->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-fw fa-eye"></i></a>
                                        <a href="{{ route('admin.voucher.voucher.edit', [$voucher->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.voucher.voucher.destroy', [$voucher->id]) }}"><i class="fa fa-trash"></i></button>
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
        <dd>{{ trans('pemedic::vouchers.title.create voucher') }}</dd>
    </dl>
@stop

@push('js-stack')


    <script type="text/javascript">
        $( document ).ready(function() {
            var base_url = window.location.origin;
            $('#clinic').change(function() {
                clinic = $(this).val();
                location.href = base_url + '/en/backend/pemedic/vouchers' + clinic;
            });


            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.voucher.voucher.create') ?>" }
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
