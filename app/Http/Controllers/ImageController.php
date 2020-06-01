<?php

namespace App\Http\Controllers;

use App\AnimalPhoto;
use App\Image;
use App\Auction;
use App\ProfilePhoto;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use UploadTrait;

    /**
     * Deletes an individual item.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $animal_photo = AnimalPhoto::find($id);
        $profile_photo = ProfilePhoto::find($id);

        if ($animal_photo != null) {
            $animal_photo->delete();

            $photo = Image::find($id);

            // $this->authorize('deleteAnimalPhoto', Auction::findOrFail($animal_photo->id_auction));

            $this->deleteOne($photo->url);
            $photo->delete();
            return $photo;
        } else if ($profile_photo != null) {
            $profile_photo->delete();

            $photo = Image::find($id);

            // $this->authorize('deleteAnimalPhoto', Auction::findOrFail($animal_photo->id_auction));

            $this->deleteOne($photo->url);
            $photo->delete();
            return $photo;
        }
        return $id;
    }
}
