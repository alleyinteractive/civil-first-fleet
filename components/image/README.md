# Image Component
This component is for rendering any image uploaded to the WP media library, including featured images for all content types. Functionality is also included for:
* Responsive image markup using both:
    * `<img>` with `srcset` and `sizes`
    * `<picture>`/`<source>` for art direction
* Lazy loading images and auto-setting `sizes` with [`lazysizes`](https://github.com/aFarkas/lazysizes).
* Configurable handling of image sizes/positions
* Integration with the [Photon API](https://developer.wordpress.com/docs/photon/api/) to apply image transformations. Currently supported transforms:
    * `w` - set the width of an image
    * `h` - set the height of an image
    * `crop` - crop an image
    * `resize` - resize and crop an image to an exact width and height
    * `fit` - fit an image into a containing width and height while maintaining original aspect ratio
    * `quality` - modify compression quality of image
* Handling of [intrinsic ratio sizing](https://alistapart.com/d/creating-intrinsic-ratios-for-video/example2.html) using CSS.

## Rendering the component
Rendering the image component works just like rendering any other component, with the added requirement you provide an attachment ID and an image size:
```php
$component->image()
    ->set_post_id( $featured_image_id )
    ->size( 'large-feature' )
    ->render();
```
In addition, there are several other helper methods you can call to modify the image output. Below is documentation of all helper methods:
* `register_sizes` - **REQUIRED** register image sizes and corresponding configurations (see configuration docs below)
* `register_breakpoints` - register breakpoints for use in media attributes (see configuration docs below)
* `set_post_id` - **REQUIRED** provide an attachment ID for querying the attachment URL, original dimensions, etc.
* `size` - **REQUIRED** provide an image size string, the configuration for which is used to construct the responsive image markup
* `set_url` - set a new URL for the image
* `disable_lazyload` - disable lazy loading for this image
* `aspect_ratio` - set aspect ratio for use with CSS intrinsic ratio sizing. Pass `false` to this function to disable CSS sizing entirely.

In addition, all Photon transforms may be applied via method. Note, however, that doing this will apply the transform to _all_ sources in the resulting `srcset` or series of `<source>` tags.

## Configuration
Some configuration is required to use the image component. You need to declare at least one image size and configure its corresponding transforms and descriptor using the `register_sizes` method of the `Image` class. Example:
```php
/**
 * Register image sizes for use by the Image component.
 */
\Civil_First_Fleet\Component\Image::register_sizes( [
    'large-feature' => [
        'sources' => [
            [
                'transforms' => [
                    'resize' => [ 950, 627 ],
                ],
                'descriptor' => 949,
            ],
            [
                'transforms' => [
                    'resize' => [ 800, 528 ],
                ],
                'descriptor' => 800,
            ],
        ],
    ],
] );
```

In addition, if you need to use a `<picture>` element you'll need to register breakpoints and use them in the `media` property for each image source. The reason for this is `<source>` tags will be ignored if a `media` attribute is not provided. Example:

```php

\Civil_First_Fleet\Component\Image::register_breakpoints( [
    'xl' => '80rem',
    'lg' => '64rem',
    'md' => '48rem',
    'sm' => '32rem',
] );

\Civil_First_Fleet\Component\Image::register_sizes( [
    'large-feature' => [
        'sources' => [
            [
                'transforms' => [
                    'resize' => [ 950, 627 ],
                ],
                'descriptor' => 949,
                'media' => [ 'min' => 'lg' ]
            ],
            [
                'transforms' => [
                    'resize' => [ 800, 528 ],
                ],
                'descriptor' => 800,
                'media' => [ 'max' => 'md' ]
            ],
        ],
    ],
] );
```

Below is a more detailed breakdown of each configuration property when registering sizes:
* `large-feature` - image size key. Used when calling `size()` method before rendering the component
    * `sources` - array of sources to include in `srcset` attribute in the case of an `<img>` tag, or `<source>` tags in the case of `<picture>`
        * `transforms` - array of Photon transformations to apply to this source. You can apply any number or combination of transforms per-source.
            * `resize` - configuration for Photon transforms. Any of the transforms listed in the first section of this document may be configured here.
        * `descriptor` - an integer representing a width descriptor for the image. This is required for the browser to determine which image source to choose (see documentation for [`srcset`](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/img) attribute)
        * `media` - an array describing the media conditions for which this source should be applied. Media has three options:
            * `min` - a string representing a breakpoint (taken from your registered breakpoints) for use as a `min-width`
            * `max` - a string representing a breakpoint (taken from your registered breakpoints) for use as a `max-width`
            * `custom` - a custom breakpoint value. If used, this should contain the _full_ representation of the media query. For example, if you want both a min and max height you need to write out `(min-height: 400px) and (max-height: 600px)`

And when registering breakpoints:
* `xl` - name for the breakpoint, for use with the `media` `min` or `max` settings
* `80rem` - breakpoint that will be supplied as the value for `min-width` or `max-width`
