@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::clinics.title.clinics') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::clinics.title.clinics') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.clinic.clinic.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::clinics.button.create clinic') }}
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
                                <th>{{ trans('pemedic::clinics.table.email') }}</th>
                                <th>{{ trans('pemedic::clinics.table.name') }}</th>
                                <th>{{ trans('pemedic::clinics.table.phone') }}</th>
                                <th>{{ trans('pemedic::clinics.table.vip phone') }}</th>
                                <th>{{ trans('pemedic::clinics.table.address') }}</th>
                                <th>{{ trans('pemedic::clinics.table.word time') }}</th>
                                <th>{{ trans('pemedic::clinics.table.website') }}</th>
                                <th>{{ trans('pemedic::clinics.table.image') }}</th>
                                <th>{{ trans('pemedic::clinics.table.status') }}</th>
                                <th data-sortable="false" style="min-width: 75px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($clinics)): ?>
                            <?php foreach ($clinics as $clinic): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.clinic.clinic.edit', [$clinic->id]) }}">
                                        {{ $clinic->user->email }}
                                    </a>
                                </td>
                                <td>{{ $clinic->clinic_name }}</td>
                                <td>{{ $clinic->phone }}</td>
                                <td>{{ $clinic->vip_phone }}</td>
                                <td>{{ str_limit($clinic->address, $limit = 50, $end = '...') }}</td>
                                <td>{{ $clinic->word_time }}</td>
                                <td>{{ $clinic->website }}</td>
                                <td>
                                    <center>
                                        @if(!empty($clinic->image))
                                            <img src="{{ $clinic->image }}" alt="" style="width:150px">
                                        @endif
                                    </center>
                                </td>
                                <td>
                                    @if($clinic->user->isActivated())
                                        <span class="label label-primary">{{ trans('pemedic::clinics.table.active') }}</span>
                                    @else
                                        <span class="label label-danger">{{ trans('pemedic::clinics.table.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.clinic.clinic.edit', [$clinic->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.clinic.clinic.destroy', [$clinic->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('pemedic::clinics.table.email') }}</th>
                                <th>{{ trans('pemedic::clinics.table.name') }}</th>
                                <th>{{ trans('pemedic::clinics.table.phone') }}</th>
                                <th>{{ trans('pemedic::clinics.table.vip phone') }}</th>
                                <th>{{ trans('pemedic::clinics.table.address') }}</th>
                                <th>{{ trans('pemedic::clinics.table.word time') }}</th>
                                <th>{{ trans('pemedic::clinics.table.website') }}</th>
                                <th>{{ trans('pemedic::clinics.table.image') }}</th>
                                <th>{{ trans('pemedic::clinics.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
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
        <dd>{{ trans('pemedic::clinics.title.create clinic') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.clinic.clinic.create') ?>" }
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
