Ideato\FlickrApiBundle
========================

How to use it
--------------

 * Add the api_key and the user_id as parameters in yout services configuration:

        <parameters>
            <parameter key="flickr_api.user_id">44774306@N00</parameter>
            <parameter key="flickr_api.api_key">a6d472134d5877b51a38070c7c631956</parameter>
        </parameters>

 * To retrieve the photo sets in your controller:

    $photo_sets = $this->get('flickr_api.photogallery_repository')->getPhotoGalleriesPreview();

and to display them:

    <ul>
        {% for photo_set in photo_sets %}
        <li>
            <a href="{{ path('photogallery', { 'photoset_id' : photo_set.id }) }}">
                <img alt="{{ photo_set.title }}" src="{{ photo_set.preview }}">
            </a>
            <h4>{{ photo_set.title }}</h4>
            <p>{{ photo_set.description }}</p>
        </li>
        {% endfor %}
    </ul>

* To retrieve only a specific photo set in your controller:

    $photo_set = $this->get('flickr_api.photogallery_repository')->getPhotoGallery($photoset_id);
    if (!$photo_set)
    {
        return new Response('Error message!', 404);
    }

and to diplay it:

    <ul>
        {% for photo in photo_set.photos %}
        <li>
            <a href="{{ photo.url }}">
                <img alt="{{ photo.title }}" src="{{ photo.preview }}">
            </a>
            <h4>{{ photo.title }}</h4>
            <p>{{ photo.description }}</p>
        </li>
        {% endfor %}
    </ul>


* You can access the flickr api directly througt the service "flickr_api.api":

    $container->get('flickr_api.api');
