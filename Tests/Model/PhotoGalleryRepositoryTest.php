<?php

namespace Ideato\FlickrApiBundle\Tests\Model;

use Ideato\FlickrApiBundle\Model\PhotoGalleryRepository;

class PhotoGalleryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPhotoGalleriesPreview()
    {
        $xml_mock_sets_results = \simplexml_load_file(__DIR__.'/../../DataFixtures/Files/flickr_api_get_sets_results.xml');

        $flickr_api = $this->getMock('Ideato\FlickrApiBundle\Wrapper\FlickrApi', array('getPhotoSets'), array(), '', false);
        $flickr_api->expects($this->any())
                   ->method('getPhotoSets')
                   ->will($this->returnValue($xml_mock_sets_results));

        $photo_repository = $this->getMock('\Ideato\FlickrApiBundle\Model\PhotoRepository');

        $repository = new PhotoGalleryRepository($flickr_api, $photo_repository);


        $photogalleries = $repository->getPhotoGalleriesPreview();

        $this->assertEquals(6, count($photogalleries));
        foreach ($photogalleries as $photogallery)
        {
            $this->assertTrue($photogallery instanceof \Ideato\FlickrApiBundle\Model\PhotoGallery);
        }

        $this->assertEquals('72157623940754473', $photogalleries[0]->getId());
        $this->assertEquals('Flickr cup 1', $photogalleries[0]->getTitle());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean at orci in nisl commodo malesuada. Ut varius, sem vel tempus elementum, nisl tortor tincidunt diam, et eleifend libero est vel nunc.', $photogalleries[0]->getDescription());
        $this->assertEquals('http://farm2.static.flickr.com/1134/4609025198_196fbbd66d_m.jpg', $photogalleries[0]->getPreview());
        $this->assertEquals(array(), $photogalleries[0]->getPhotos());
    }

    public function testGetPhotoGallery()
    {
        $xml_mock_set_result = \simplexml_load_file(__DIR__.'/../../DataFixtures/Files/flickr_api_get_set_result.xml');

        $flickr_api = $this->getMock('Ideato\FlickrApiBundle\Wrapper\FlickrApi', array('getPhotoSet'), array(), '', false);
        $flickr_api->expects($this->any())
                   ->method('getPhotoSet')
                   ->with('72157623940754473')
                   ->will($this->returnValue($xml_mock_set_result));

        $photo_repository = $this->getMock('\Ideato\FlickrApiBundle\Model\PhotoRepository', array('getPhotosFromXml'));
        $photo_repository->expects($this->any())
                         ->method('getPhotosFromXml')
                         ->will($this->returnValue(array()));

        $repository = new PhotoGalleryRepository($flickr_api, $photo_repository);
        $photogallery = $repository->getPhotoGallery('72157623940754473');

        $this->assertTrue($photogallery instanceof \Ideato\FlickrApiBundle\Model\PhotoGallery);

        $this->assertEquals('72157623940754473', $photogallery->getId());
        $this->assertEquals('Flickr cup 1', $photogallery->getTitle());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean at orci in nisl commodo malesuada. Ut varius, sem vel tempus elementum, nisl tortor tincidunt diam, et eleifend libero est vel nunc.', $photogallery->getDescription());
        $this->assertEquals(0, count($photogallery->getPhotos()));
    }
}
