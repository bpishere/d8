<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'Cache node list' block.
 *
 * @Block(
 *   id = "cache_node_list",
 *   admin_label = @Translation("Cache node list")
 * )
 */
class CacheNodeList extends BlockBase implements  ContainerFactoryPluginInterface{
  private $database;
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('database')

    );
  }


  /**
   * {@inheritdoc}
   */
  public function build() {

    $result = $this->database->select('node_field_data', 'n')
        ->fields('n', array('nid','title'))
        ->orderBy('nid', 'DESC')//ORDER BY created
        ->range(0,5)
        ->execute()
        ->fetchAll();
    $rows = array();
    $cache_tags = array();
    $cache_tags[] = 'node_list';
    foreach ($result as $row) {
      // Normally we would add some nice formatting to our rows
      // but for our purpose we are simply going to add our row
      // to the array.
      $rows[] = $row->title;
      $cache_tags[] = 'node:' . $row->nid;

    }
   //var_dump($result);
    //$user = \Drupal::currentUser()->getAccount();
    $mail = \Drupal::currentUser()->getEmail();
    return array(
        '#type' => 'markup',
        '#markup' => implode("<br/>", $rows) .'user -' . $mail,
        '#cache' => array(
            'tags'=>$cache_tags,  /// Adding cache tags to invalidate this custom block cache during update of these nodes
            'contexts' => array('user') // Adding cache context to invalidate cache during adding or removing new nodes.
        )

      //'#attach' =>  //
    );
  }

}
