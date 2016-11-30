<?php
namespace Drupal\d8training;

use Drupal\Core\Database\Driver\mysql\Connection;

/// Creating sevice
class FormManager
{
    private $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function fetchData()
    {
        $query = $this->database->select('d8training', 'd8t');
        $query->fields('d8t', array());
        $query->orderBy('id', 'desc');
        $query->range(0, 1);
        $rs = $query->execute()->fetchAssoc();
        return $rs['title'];
    }

    public function addData($title,$description)
    {
        $query = $this->database->insert('d8training');
        $query->fields([
            'title',
            'description'
        ]);
        $query->values([
            $title,
            $description
        ]);
        $query->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'simple_form';
    }




}
