<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Tag;

class Tagger extends Controller
{
    const IMG_URL_BASE = 'http://testurl.com/images/';

    /**
     * Find image by id or grab first unprocessed image
     *
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index($id = null)
    {
        $img = isset($id)
            ? $img = Gallery::findOrFail($id)
            : $img = Gallery::all()->whereNull('processed')->first();

        $imgUrl = '';
        if (!empty($img)) {
            $imgUrl = self::IMG_URL_BASE . $img->image_url;
        } else {
            abort(404);
        }

        return view('tagger', $data = ['id' => $img->id, 'imgUrl' => $imgUrl]);
    }

    /**
     * Marks image as processed and requests next image
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function next(Request $request)
    {
        // Set current image processed status
        $id = $request->input('id');
        Gallery::setProcessed($id);

        // Redirect to next random image
        return redirect()->action('Tagger@index');
    }

    /**
     * Add a new tag to a gallery image
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addTag(Request $request)
    {
        $galleryId = $request->input('galleryId');
        $newTag = $request->input('newTag');

        $tag = new Tag();
        $tag->gallery_id = $galleryId;
        $tag->tag = $newTag;
        $tag->save();

        return response()->json([
            'galleryId' => $galleryId,
            'newTag' => $newTag,
        ], 200);
    }
}
