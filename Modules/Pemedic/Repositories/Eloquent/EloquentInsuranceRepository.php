<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\InsuranceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentInsuranceRepository extends EloquentBaseRepository implements InsuranceRepository
{
	/**
     * Store a newly created resource in storage.
     *
     * @param  CreateInsuranceRequest $request
     * @param  $allRequest
     * @return Insurance Object
     */
	public function createInsurance($request,$allRequest)
	{
		if($request->hasFile('image')){
            $file = $request->file('image');
            $url = $this->uploadFile($file);
            $allRequest['image'] = $url;
        }
        $insurance = $this->create($allRequest);
        return $insurance;
	}
	/**
     * Update the specified resource in storage.
     *
     * @param  Insurance $insurance
     * @param  UpdateInsuranceRequest $request
     * @param  $allRequest
     * @return Insurance Object
     */
	public function updateInsurance($insurance,$request,$allRequest)
	{
		if($request->hasFile('image')){
            $file = $request->file('image');
            $url = $this->uploadFile($file);
            $allRequest['image'] = $url;
        }
        $insurance = $this->update($insurance,$allRequest);
        return $insurance;
	}

	/**
     * Upload file local Storage
     *
     * @param  $file
     */
    protected function uploadFile($file)
    {
        $s3 = \Storage::disk('local');
        $time = time();
        $filePath = 'public/assets/insurances/' .$time.'-'. $file->getClientOriginalName();
        $url = '/assets/insurances/' .$time.'-'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
}
