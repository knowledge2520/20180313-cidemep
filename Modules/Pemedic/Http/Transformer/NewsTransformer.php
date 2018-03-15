<?php 
namespace Modules\Pemedic\Http\Transformer;

use Logaretm\Transformers\Transformer;
class NewsTransformer extends Transformer
{
    /**
     * @param $user
     * @return mixed
     */
    public function getTransformation($news)
    {
        return [
            'id' => $news->id,
            'title' => $news->title ? $news->title : "",
            'content' => $news->content ? $news->content : "",
            'image' => $news->image ? $news->image : "",
            'created_at' => $news->created_at ? \Carbon\Carbon::parse($news->created_at)->format('d/m/Y  H:i:s') : ""
        ];
    }
}