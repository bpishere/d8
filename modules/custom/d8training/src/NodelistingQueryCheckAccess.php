<?php
namespace Drupal\d8training;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\HttpFoundation\Request;


class NodelistingQueryCheckAccess implements AccessInterface {
   
public function access (Request $request){
 $qs = $request->getQueryString();
 //dsm($qs);
  //  print 'hello';
 //print_r($qs); die;
 if($qs){
     return AccessResult::allowed()->cachePerPermissions();
 }else{
     return AccessResult::forbidden();
 }

}


}
