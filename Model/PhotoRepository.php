<?php

namespace Ideato\FlickrApiBundle\Model;

use Ideato\FlickrApiBundle\Model\Photo;

class PhotoRepository
{
    /**
     * Builds an array of Ideato\FlickrApiBundle\Model\Photo object based on the SimpleXMLElement given
     *
     * @param \SimpleXMLElement $xml
     * @param string $preview_size
     * @param string $image_size
     * @return array of Ideato\FlickrApiBundle\Model\Photo object
     */
    public function getPhotosFromXml(\SimpleXMLElement $xml, $preview_size = 's', $image_size = 'm')
    {
        $photos = array();
        foreach ($xml->photo as $photo)
        {
            $attributes = $photo->attributes();

            $photo = new Photo();
            $photo->setId((string)$attributes['id']);
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
