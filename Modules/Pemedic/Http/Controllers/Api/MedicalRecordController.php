<?php

namespace Modules\Pemedic\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Pemedic\Service\AuthService;
use Modules\Pemedic\Services\MedicalService;
use Hash;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Pemedic\Http\Transformer\UserTransformer;
use Modules\Pemedic\Http\Transformer\MedicalRecordTransformer;
use Modules\Pemedic\Repositories\MedicalRecordRepository;
use Modules\Pemedic\Entities\MedicalRecordFile;
use Modules\Pemedic\Http\Requests\Api\Medical\DeleteMedicalRecordRequest;

class MedicalRecordController extends ApiBaseController
{
    protected $auService; 

    /**
     * @var MedicalRecordRepository
     */
    private $medicalRecordRepository;

    /**
     * @var MedicalService
     */
    private $service;

    public function __construct(AuthService $auService,MedicalRecordRepository $medicalRecordRepository, MedicalService $service)
    {
         $this->auService = $auService;
         $this->medicalRecordRepository = $medicalRecordRepository;
         $this->service = $service;
    }
    /**
     * @SWG\Get(
     *   path="/medical/getListMedicalRecord",
     *   description="",
     *   summary="",
     *   operationId="api.medical.getListMedicalRecord",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Parameter(
     *     description="",
     *     in="path",
     *     name="take",
     *     required=false,
     *     type="integer",
     *     default="10" 
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="path",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getListMedicalRecord(Request $request, MedicalRecordTransformer $transformer)
    {
        $patient = Auth::guard('api')->user();
        $take = $request->take ? $request->take : config('asgard.pemedic.config.take');
        $page = $request->page ? $request->page : 1;
        
        $medicalRecords = $this->service->getListMedicalRecords($patient, $page, $take);
        $items = $this->service->getAllMedicalRecords($patient);
        $paginator = $this->service->getPaginator($items, $page, $take);
        return $this->respondWithPagination($paginator, $transformer->transform($medicalRecords));
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

    /**
     * @SWG\Get(
     *   path="/medical/getDetailMedicalRecord?id={id}",
     *   summary="View",
     *   operationId="api.v1.medical.getDetailMedicalRecord",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Parameter(
     *     description="",
     *     in="path",
     *     name="id",
     *     required=true,
     *     type="integer",
     *     default="" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function getDetailMedicalRecord(Request $request, MedicalRecordTransformer $transformer)
    {
        $patient = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        $item = $this->service->findMedicalRecord($id, $patient);

        if(!count($item)){
            return $this->respondNotFound('Item not found');
        }

        return $this->respondWithSuccess($transformer->transform($item));

    }
    
    /**
     * @SWG\Post(
     *   path="/medical/updateMedicalRecord",
     *   summary="View",
     *   operationId="api.v1.medical.updateMedicalRecord",
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
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function updateMedicalRecord(UpdateMedicalRecordRequest $request)
    {
        $patient = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        $item = $this->service->findMedicalRecord($id, $patient);

        if(!count($item)){
            return $this->respondNotFound('Item not found');
        }

        // update item
        $this->service->deleteMedicalRecord($id);

        return $this->respondWithMessage('Deleted successfully');

    }

    /**
     * @SWG\Post(
     *   path="/medical/deleteMedicalRecord",
     *   summary="View",
     *   operationId="api.v1.medical.deleteMedicalRecord",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Parameter(
     *     description="",
     *     in="formData",
     *     name="id",
     *     required=true,
     *     type="string",
     *     default="" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function deleteMedicalRecord(DeleteMedicalRecordRequest $request)
    {
        $patient = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        $item = $this->service->findMedicalRecord($id, $patient);

        if(!count($item)){
            return $this->respondNotFound('Item not found');
        }

        // delete item
        $this->service->deleteMedicalRecord($id);

        return $this->respondWithMessage('Deleted successfully');

    }

    /**
     * @SWG\Post(
     *   path="/medical/deleteMedicalRecordFile",
     *   summary="View",
     *   operationId="api.v1.medical.deleteMedicalRecordFile",
     *   produces={"application/json"},
     *   tags={"MedicalRecord"},
     *   @SWG\Parameter(
     *     description="",
     *     in="formData",
     *     name="id",
     *     required=true,
     *     type="string",
     *     default="" 
     *   ),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     *
     */
    public function deleteMedicalRecordFile(DeleteMedicalRecordRequest $request)
    {
        $patient = Auth::guard('api')->user();
        $id = $request->id ? $request->id : false;

        $item = $this->service->findMedicalRecord($id, $patient);

        if(!count($item)){
            return $this->respondNotFound('Item not found');
        }

        // delete item
        $this->service->deleteMedicalRecord($id);

        return $this->respondWithMessage('Deleted successfully');

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
