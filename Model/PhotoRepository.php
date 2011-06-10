<?php

namespace Ideato\FlickrApiBundle\Model;

use Ideato\FlickrApiBundle\Model\Photo;

class PhotoRepository
{
    public function getPhotosFromXml(\SimpleXMLElement $xml, $preview_size = 's', $image_size = 'm')
    {
        $photos = array();
        foreach ($xml->photo as $photo)
        {
            $attributes = $photo->attributes();

            $photo = new Photo();
            $photo->setUrl('http://www.flickr.com/'.$attributes['pathalias'].'/'.$attributes['id']);
            $photo->setTitle($attributes['title']);
            $photo->setDescription('');
            $photo->setPreview($attributes['url_'.$preview_size]);
            $photo->setImage($attributes['url_'.$image_size]);

            $photos[] = $photo;

        }

        return $photos;
    }
}
