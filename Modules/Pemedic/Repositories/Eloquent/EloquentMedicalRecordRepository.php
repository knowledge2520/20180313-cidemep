<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentMedicalRecordRepository extends EloquentBaseRepository implements MedicalRecordRepository
{
	public function showListMedicalRecordByPatient($patient)
	{
		$medicalRecords = $this->model->where('patient_id',$patient->id)->groupBy('clinic_id')->get();
		return $medicalRecords;
	}
}
