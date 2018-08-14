<?php

namespace Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Form\RegisterForm;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class GunsController implements ControllerProviderInterface
{

    const TYPE_FIRST = 1;
    const TYPE_SECOND = 2;

    public static $TYPES = [

    ];


    /**
     * Routing settings.
     *
     * @param \Silex\Application $app Silex application
     *
     * @return \Silex\ControllerCollection Result
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];
        $controller->match('/', array($this, 'indexAction'))
            ->bind('guns');

        return $controller;
    }

    /**
     * Index action.
     *
     * @param \Silex\Application                        $app     Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     *
     * @return string Response
     */
    public function indexAction(Application $app, Request $request)
    {
        $conn = $app['db'];
        $query = 'SELECT * FROM `lock_types`';
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        dump($result);
//        $conn->insert('users', $data);

        $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('name', TextType::class, array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Name'
            ))
            ->add('is_blackpowder', CheckboxType::class, array(
                'required' => false,
                'label' => 'Is your weapon blackpowder?'
            ))
            ->add('ammunition_type', CheckboxType::class, array(
                'required' => false,
                'label' => 'Ammunition type'
            ))
            ->add('gun_type', CheckboxType::class, array(
                'required' => false,
                'label' => 'Gun type'
            ))
            ->add('reload_type', CheckboxType::class, array(
                'required' => false,
                'label' => 'Reload type'
            ))
            ->add('lock_type', TextType::class, array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Lock type'
            ))
            ->add('caliber',NumberType::class, array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Caliber'
            ))
            ->add('permission', CheckboxType::class, array(
                'required' => false,
                'label' => 'Is permission needed for your weapon?'
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $conn->insert('guns', $data);
            echo 'Dodano broń';
        }

        $this->view['form'] = $form->createView();

        return $app['twig']->render('guns/add.html.twig', array('form' => $form->createView()));
    }

}