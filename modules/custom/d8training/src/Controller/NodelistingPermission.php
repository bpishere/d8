<?php
namespace Drupal\d8training\Controller;

use Drupal\node\Entity\NodeType;


class NodelistingPermission {

    public function nodePermission() {

    $types = NodeType::loadMultiple();
    //print_r($types);
    //dsm($types);
    $permissions =[];
    foreach ($types as $type){
        $type_name = $type->get('name');
        $permissions['d8 training permission for ' . $type_name ] = array(
            'title' => 'D8 perm title for ' .$type_name,
            'description' => 'D8 perm description for ' .$type_name
        );
    }

    return $permissions;
  }




}
