<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class VoucherTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($voucher)
    {
        return [
            'id' => $voucher->id,
            'name' => $voucher->name,
            'clinic' => $voucher->clinic->clinic_name,
            'start_date' => $voucher->start_date ? \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y  H:i:s') : "",
            'expire_date' => $voucher->expiry_date ? \Carbon\Carbon::parse($voucher->expiry_date)->format('d/m/Y  H:i:s') : ""
        ];
    }
}