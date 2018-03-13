<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Service\AuthService;
use Hash;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Pemedic\Http\Transformer\UserTransformer;
use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Pemedic\Entities\MedicalRecordFile;
class MedicalRecordController extends AdminBaseController
{
    protected $auService; 

    /**
     * @var MedicalRecordRepository
     */
    private $medicalRecordRepository;


    public function __construct(AuthService $auService,MedicalRecordRepository $medicalRecordRepository)
    {
         $this->auService = $auService;
         $this->medicalRecordRepository = $medicalRecordRepository;
    }
    /**
     * @SWG\Get(
     *   path="/medical/getListMedicalRecord",
     *   description="",
     *   summary="",
     *   operationId="api.medical.getListMedicalRecord",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getListMedicalRecord(Request $request)
    {
        $patient = Auth::guard('api')->user();
        $medicalRecords = $this->medicalRecordRepository->showListMedicalRecordByPatient($patient);
        return $medicalRecords;
    }
    /**
     * @SWG\Post(
     *   path="/medical/add",
     *   description="<ul>
     *     <li>email : date (required)</li>
     *     <li>clinic_name : string (required)</li>
     *     <li>doctor_name : string (required)</li></ul>",
     *   summary="View",
     *   operationId="api.medical.add",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Parameter(
     *     description="",
     *     in="formData",
     *     name="date",
     *     required=false,
     *     type="string",
     *     default="" 
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="formData",
     *     name="doctor_name",
     *     required=false,
     *     type="string",
     *     default="" 
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="formData",
     *     name="clinic_name",
     *     required=false,
     *     type="string",
     *     default="" 
     *   ),
     *   @SWG\Parameter(
     *     name="file[]",
     *     in="formData",
     *     description="avatar's profile",
     *     required=false,
     *     type= "file",
     *   ),
     *   @SWG\Response(response=500, description="internal server error"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function add(Request $request)
    {
    	$patient = Auth::guard('api')->user();
    	$files = $request->file('file');
    	$allRequest = $request->all();
    	$allRequest['patient_id'] = $patient->id;
    	$allRequest['title'] = $request->date;
    	$medicalRecord = $this->medicalRecordRepository->create($allRequest);
	    // If the array is not empty
	    if ($files[0] != '') {
	      	// Set the destination path
		    foreach ($files as $file) {
			    // Store file. Filename is set automatically.
			    $fileName = $file->getClientOriginalName();
	            $s3 = Storage::disk('local');
	            $filePath_save = 'public/assets/manual/'.$request->date.'/'.$patient->id;
	            $path = $s3->put($filePath_save,$file,'public');
	            $this->addMedicalRecordFile($medicalRecord,$patient->id,$path);
		  	 }
	    }
	    return response([
                    'data' => [
                    'message'   =>  'Add Medical Record Success'
                    ],
            ],Response::HTTP_OK);


    }
    public function addMedicalRecordFile($medicalRecord,$patient_id,$path)
    {
    	$medicalRecordFile = new MedicalRecordFile();
    	$medicalRecordFile->patient_id = $patient_id;
    	$medicalRecordFile->medical_id = $medicalRecord->id;
    	$medicalRecordFile->path = $path;
    	$medicalRecordFile->thumbnail = $path;
    	$medicalRecordFile->save();
    }
}
