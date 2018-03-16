@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::insurances.title.insurances') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::insurances.title.insurances') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.insurance.insurance.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pemedic::insurances.button.create insurance') }}
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
                                <th>ID</th>
                                <th>{{ trans('pemedic::doctors.table.name') }}</th>
                                <th>{{ trans('pemedic::doctors.table.phone') }}</th>
                                <th>{{ trans('pemedic::doctors.table.address') }}</th>
                                <th>{{ trans('pemedic::doctors.table.image') }}</th>
                                <th>{{ trans('pemedic::doctors.table.status') }}</th>
                                <th data-sortable="false" style="min-width: 75px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($insurances)): ?>
                            <?php foreach ($insurances as $insurance): ?>
                            <tr>
                                <td>{{ $insurance->id }}</td>
                                <td>{{ $insurance->name }}</td>
                                <td>{{ $insurance->phone }}</td>
                                <td>{{ str_limit($insurance->address, $limit = 50, $end = '...') }}</td>
                                <td>
                                    <center>
                                        @if(!empty($insurance->image))
                                            <img src="{{ $insurance->image }}" alt="" style="width:150px">
                                        @endif
                                    </center>
                                </td>
                                <td>
                                    @if($insurance->status == 1)
                                        <span class="label label-primary">{{ trans('pemedic::doctors.table.active') }}</span>
                                    @else
                                        <span class="label label-danger">{{ trans('pemedic::doctors.table.inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.insurance.insurance.edit', [$insurance->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.insurance.insurance.destroy', [$insurance->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('pemedic::doctors.table.name') }}</th>
                                <th>{{ trans('pemedic::doctors.table.phone') }}</th>
                                <th>{{ trans('pemedic::doctors.table.address') }}</th>
                                <th>{{ trans('pemedic::doctors.table.image') }}</th>
                                <th>{{ trans('pemedic::doctors.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
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
        <dd>{{ trans('pemedic::insurances.title.create insurance') }}</dd>
    </dl>
@stop

@push('js-stack')

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.insurance.insurance.create') ?>" }
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
