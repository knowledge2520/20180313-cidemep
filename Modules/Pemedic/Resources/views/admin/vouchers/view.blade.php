@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pemedic::vouchers.title.add user') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pemedic::vouchers.title.add user') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="box-body">
                        <div class="col-sm-4 col-xs-12">
                            <h3 class="col-sm-12 col-xs-12">{{ $voucher->name }}</h3>
                        </div>
                        @if(!empty($voucher->image))
                        <div class="col-sm-8 col-xs-12 " >
                            <div class="jsThumbnailImageWrapper" >
                                <figure class="ui-sortable-handle">
                                    <img src="{{ $voucher->image }}" alt="" style="width:200px;">
                                </figure>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('pemedic::patients.table.no') }}</th>
                                <th>{{ trans('pemedic::patients.table.name') }}</th>
                                <th>{{ trans('pemedic::patients.table.email') }}</th>
                                <th>{{ trans('pemedic::patients.table.phone') }}</th>
                                <th>{{ trans('pemedic::patients.table.address') }}</th>
                                <th>{{ trans('pemedic::patients.table.dob') }}</th>
                                <th data-sortable="false" style="width: 50px">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($patients)): ?>
                            <?php $i=1; ?>
                            <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->user->email }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>{{ $patient->dob }}</td>
                                <td>
                                    <div class="btn-group">
                                        <?php 
                                            $voucherPatients = $voucher->users;
                                        ?>

                                        @if(count($voucherPatients)>0)
                                            <?php $temp=0; ?>
                                            @foreach($voucherPatients as $voucherPatient)
                                                @if($voucherPatient->id == $patient->user_id)
                                                    <button class="btn btn-danger btn-flat update-patient" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="2"><i class="fa fa-trash"></i> </button>
                                                    <button class="btn btn-primary btn-flat update-patient" style="display: none" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="1">
                                                        <i class="fa fa-fw fa-plus" style="width:12px;"></i> 
                                                    </button>
                                                    <?php $temp++; ?>
                                                @endif
                                            @endforeach
                                            @if($temp==0)
                                                <button class="btn btn-primary btn-flat update-patient" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="1">
                                                    <i class="fa fa-fw fa-plus" style="width:12px;"></i> 
                                                </button>
                                                <button class="btn btn-danger btn-flat update-patient" style="display: none" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="2"><i class="fa fa-trash"></i> </button>
                                            @endif
                                        @else
                                            <button class="btn btn-primary btn-flat update-patient" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="1">
                                                    <i class="fa fa-fw fa-plus" style="width:12px;"></i> 
                                            </button>
                                            <button class="btn btn-danger btn-flat update-patient" style="display: none" patient-id="{{ $patient->user_id }}" voucher-id="{{ $voucher->id }}" type="2"><i class="fa fa-trash"></i> </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
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
    <div class="hidden theurl">{{ URL::route('admin.voucher.voucher.addPatient') }}</div>
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

            $('.update-patient').click(function() {
                patient_id = $(this).attr("patient-id");
                voucher_id = $(this).attr("voucher-id");
                type       = $(this).attr("type");
                $(this).hide();
                $(this).siblings().show();
                $(this).next(".btn-danger").show();
                $.ajax({
                    type : 'GET',
                    url : $('.theurl').text(),
                    data : {'patient_id':patient_id,'voucher_id':voucher_id,'type':type},
                    success:function(data){
                        console.log(data);
                    }
                });
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
