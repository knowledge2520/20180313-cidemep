<?php
/**
 * Get Data Locale New Translation
 *
 * @param  News $new
 * @param  $locale
 */
if (! function_exists('getDataLocaleNewTranslation')) {
    function getDataLocaleNewTranslation($new,$locale = 'vi')
    {
    	if(empty($locale))
    	{
    		$locale = app()->make('config')->get('translatable.locale')
            ?: app()->make('translator')->getLocale();
    	}
        $newTranslation = \Modules\Pemedic\Entities\NewsTranslation::where('new_id',$new->id)->where('locale',$locale)->first();
        return $newTranslation;
    }
}