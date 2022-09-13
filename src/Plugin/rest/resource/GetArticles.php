<?php

namespace Drupal\site_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "articles",
 *   label = @Translation("List of Articles"),
 *   uri_paths = {
 *     "canonical" = "/get/articles"
 *   }
 * )
 */

class GetArticles extends ResourceBase {

    /**
     * Responds to entity GET requests.
     * @return \Drupal\rest\ResourceResponse
     */
    public function get() {
      $response = ['message' => 'Hello, this is a rest service for durpal site'];
      return new ResourceResponse($response);
    }
  }