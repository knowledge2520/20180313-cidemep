<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\VoucherPatientRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Hash;
use DB;

class EloquentVoucherPatientRepository extends EloquentBaseRepository implements VoucherPatientRepository
{

}