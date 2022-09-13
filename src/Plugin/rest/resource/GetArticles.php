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
      //$response = ['message' => 'Hello, this is a rest service for durpal site'];
      $nids = \Drupal::entityQuery('node')->condition('type','article')->execute();
      $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
      $response = $this->processNode($nodes);
      return new ResourceResponse($response);
    }

    /**
     * Get Articles
     */
    private function processNode($nodes) 
    {
      $output = [];
      foreach($nodes as $key => $node)
      {
        $ouput[$key]['title'] = $node->get('title')->getValue();
      }
      return $output;
    }
  }