<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class Tagger extends Controller
{
    const IMG_URL_BASE = 'http://testurl.com/images/';

    function index($id = null)
    {
        // Find image by id or grab first unprocessed image
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
}
