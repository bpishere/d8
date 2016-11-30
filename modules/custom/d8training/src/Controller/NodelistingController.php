<?php
namespace Drupal\d8training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Database\Driver\mysql\Connection;


class NodelistingController extends ControllerBase
{

    private $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public static function create(ContainerInterface $container)
    {
///$container->get('logger.dblog'),

        return new static($container->get('database')

        );
    }

    public function contenttabone()
    {
        $header = array(
            // The header gives the table the information it needs in order to make
            // the query calls for ordering. TableSort uses the field information
            // to know what database column to sort by.
            array('data' => t('Nid'), 'field' => 'n.nid'),
            array('data' => t('Vid'), 'field' => 'n.vid'),
            array('data' => t('Type'), 'field' => 'n.type'),
        );


        // Using the TableSort Extender is what tells  the query object that we
        // are sorting.
        $query = $this->database->select('node', 'n')
            ->extend('Drupal\Core\Database\Query\TableSortExtender');
        //$query->fields('n', array('n.nid', 'n.title', 'n.uid'));
        $query->fields('n', array('nid', 'vid', 'type'));

        // Don't forget to tell the query object how to find the header information.
        $result = $query
            ->orderByHeader($header)
            ->execute();

        $rows = array();
        foreach ($result as $row) {
            // Normally we would add some nice formatting to our rows
            // but for our purpose we are simply going to add our row
            // to the array.
            $rows[] = array('data' => (array)$row);
        }

        // Build the table for the nice output.
        $build = array(
            '#markup' => '<p>' . t('The layout here is a themed as a table
           that is sortable by clicking the header name.') . '</p>',
        );
        $build['tablesort_table'] = array(
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
        );

        return $build;
    }

    public function contenttabtwo()
    {

        return array(
            '#theme' => 'item_list',
            '#items' => array(58, 59),
        );

    }

    public function contentshowtwo($arg)
    {

        return array(
            '#theme' => 'item_list',
            '#items' => array('Hello ' . $arg . ' How are you?', 4),
        );

    }


    public function contentshowthree(NodeInterface $node)
    {

        $node->setTitle('Hey Braham !!');

        return array(
            '#theme' => 'item_list',
            '#items' => array($node->getTitle(), 5),
        );
        // $options = array($node->getTitle() );
        //  return new JsonResponse($options);

//$response = new Response();
//$response->setContent(json_encode(array('hello' => 'world', 'goodbye' => 'world')));
//$response->headers->set('Content-Type', 'application/json');
//return $response;

    }


}
