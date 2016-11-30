<?php
namespace Drupal\d8training\Form;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\Component\DependencyInjection\Container;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\d8training\FormManager;

class SimpleForm extends FormBase
{
    private $formMgr;

    public function __construct(FormManager $formMgr)
    {
        $this->formMgr = $formMgr;
    }

    public static function create(ContainerInterface $container)
    {
        // To use service "d8training.form_manager"
        return new static($container->get('d8training.form_manager'));
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'simple_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $title = $this->formMgr->fetchData();
        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => t('Title'),
            '#required' => TRUE,
            '#default_value' =>$title
        );

        $form['description'] = array(
            '#type' => 'textarea',
            '#title' => t('Description'),
        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Submit'),
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        // Validate title val should be more than 5 char
        $title = $form_state->getValue('title');
        if (strlen($title) <= 5) {
            $form_state->setErrorByName('title', $this->t("Title '%title' should be more than 5 chars", array('%title' => $form_state->getValue('title'))));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Display result.
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
        }
        /// Inserting data in database
        /**
        $query = $this->database->insert('d8training');
        $query->fields([
            'title',
            'description'
        ]);
        $query->values([
            $form_state->getValue('title'),
            $form_state->getValue('description')
        ]);
        $query->execute();
         * **/

        $this->formMgr->addData($form_state->getValue('title'), $form_state->getValue('description'));
    }


}
