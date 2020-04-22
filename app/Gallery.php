<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery';

    /**
     * Set processed status, so the image doesn't show up again in the tagger
     * @param $id
     */
    static function setProcessed($id)
    {
        $img = self::find($id);
        $img->processed = true;
        $img->save();
    }
}
