<?php

namespace Modules\Pemedic\Repositories\Eloquent;

use Modules\Pemedic\Repositories\NewRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Pemedic\Entities\NewsTranslation;
use Modules\Pemedic\Entities\News;

class EloquentNewRepository extends EloquentBaseRepository implements NewRepository
{
	/**
     * Store a newly created resource in storage.
     *
     * @param  CreateNewsRequest $request
     */
    public function createNew($request)
    {
    	// $new =  $this->create($request->all());
    	$new = new News();
    	$new->save();
    	if($request->has('en')){
    		$allRequestEN = $request->en;
    		if($request->hasFile('en.image')){
    			$file = $request->file('en.image');
    			$url = $this->uploadFile($file);
    			$allRequestEN['image'] = $url;
    			$allRequestEN['image_thumb'] = $url;
    		}
    		
    		$allRequestEN['locale'] = 'en';
    		$allRequestEN['new_id'] = $new->id;
    		$newsTranslation = NewsTranslation::create($allRequestEN);
    	}
    	if($request->has('vi')){
    		$allRequestVI = $request->vi;
    		if($request->hasFile('vi.image')){
    			$file = $request->file('vi.image');
    			$url = $this->uploadFile($file);
    			$allRequestVI['image'] = $url;
    			$allRequestVI['image_thumb'] = $url;
    		}
    		
    		$allRequestVI['locale'] = 'vi';
    		$allRequestVI['new_id'] = $new->id;
    		$newsTranslation = NewsTranslation::create($allRequestVI);
    	}
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  News $new
     * @param  UpdateNewsRequest $request
     */
    public function updateNew($new,$request)
    {
        if($request->has('en')){
            $allRequestEN = $request->en;
            if($request->hasFile('en.image')){
                $file = $request->file('en.image');
                $url = $this->uploadFile($file);
                $allRequestEN['image'] = $url;
                $allRequestEN['image_thumb'] = $url;
            }
            
            $allRequestEN['locale'] = 'en';
            $allRequestEN['new_id'] = $new->id;
            $translation = getDataLocaleNewTranslation($new,'en');
            if(isset($translation) && !empty($translation)){
                
                $translation->update($allRequestEN);
            }
            else{
                NewsTranslation::create($allRequestEN);
            }
            
        }
        if($request->has('vi')){
            $allRequestVI = $request->vi;
            if($request->hasFile('vi.image')){
                $file = $request->file('vi.image');
                $url = $this->uploadFile($file);
                $allRequestVI['image'] = $url;
                $allRequestVI['image_thumb'] = $url;
            }
            
            $allRequestVI['locale'] = 'vi';
            $allRequestVI['new_id'] = $new->id;
            $translation = getDataLocaleNewTranslation($new,'vi');
            if(isset($translation) && !empty($translation)){
                $translation->update($allRequestVI);
            }
            else{
                NewsTranslation::create($allRequestVI);
            }
        }
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
        $filePath = 'public/assets/news/' .$time.'-'. $file->getClientOriginalName();
        $url = '/assets/news/' .$time.'-'. $file->getClientOriginalName();
        $result = $s3->put($filePath, file_get_contents($file),'public');
        if($result)
        {
            return $url;
        } 
    }
}
