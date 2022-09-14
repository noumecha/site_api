<?php

namespace Drupal\site_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\node\Entity\Node;
use Drupal\rest\ResourceResponse;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "articles",
 *   label = @Translation("List of Articles"),
 *   uri_paths = {
 *     "canonical" = "/get/articles",
 *     "create" = "add/articles"
 *   }
 * )
 */

class GetArticles extends ResourceBase {

    /**
     * Responds to entity GET requests.
     * @return \Drupal\rest\ResourceResponse
     */
    public function get() {
      try {
        //$response = ['message' => 'Hello, this is a rest service for durpal site'];
        $nids = \Drupal::entityQuery('node')->condition('type','article')->execute();
        $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
        $response = $this->processNode($nodes);
        return new ResourceResponse($response);
      } catch (EntityStorageException $e) {
        \Drupal::logger('custom-rest')->error($e->getMessage());
      }
    }

    /**
     * Get Articles
     */
    private function processNode($nodes) 
    {
      $output = [];
      foreach($nodes as $key => $node)
      {
        $output[$key]['title'] = $node->get('title')->getValue();
        $output[$key]['node_id'] = $node->get('nid')->getValue();
        $output[$key]['body'] = $node->get('body')->getValue();
      }
      return $output;
    }

    /**
     * Post Articles 
     */
    public function post($data) 
    {
      if (isset($data)) {
        try {
          //dump($data['body']);exit;
          // Create node object with attached file.
          /*$node = Node::create(array(
            'type' => $data['type'],
            'title' => $data['title'],
            'body' => $data['body'],
            'langcode' => 'fr',
            'status' => 1,
          ));
          $node->save();*/
          $new_term = Term::create([
            'name' => $data['title'],
            'vid' => $data['type']
          ]);
          $new_term->save();
          return new ResourceResponse('Noeud ajouter avec succès dans '. $data['type']);
        } catch (EntityStorageException $e) {
          \Drupal::logger('custom-rest')->error($e->getMessage());
        }
      }
    }
  }