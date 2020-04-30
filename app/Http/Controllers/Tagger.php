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
        // Find an image by provided id or find next unprocessed image
        $img = isset($id)
            ? $img = Gallery::findOrFail($id)
            : $img = Gallery::all()->whereNull('processed')->first();

        // Generate image url or fail if empty result from previous query, i.e no unprocessed images remain
        $imgUrl =  (!empty($img))
            ? $imgUrl = self::IMG_URL_BASE . $img->image_url
            : abort(404);

        // Render view
        return view('tagger', $data = [
            'id' => $img->id,
            'imgUrl' => $imgUrl,
        ]);
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

    /**
     * Get results for typeahead search
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $tags = Tag::where('tag', 'LIKE', "%{$request->input('query')}%")
            ->distinct('tag')
            ->pluck('tag');

        return response()->json($tags);
    }
}
