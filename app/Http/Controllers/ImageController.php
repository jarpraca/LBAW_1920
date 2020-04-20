<?php

namespace App\Http\Controllers;

use App\AnimalPhoto;
use App\Image;
use App\Auction;

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
      if($animal_photo != null){
        $animal_photo->delete();

        $photo = Image::find($id);

        
        $folder = '/uploads/images/';
        // $this->authorize('deleteAnimalPhoto', Auction::findOrFail($animal_photo->id_auction));

        $this->deleteOne($photo->url);
        $photo->delete();
        return $photo;
      }
      return $id;

    }

}
