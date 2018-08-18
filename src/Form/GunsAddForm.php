<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 03.08.18
 * Time: 12:55
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class GunsAddForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        return $builder
            ->add('name', TextType::class, array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Name'
            ))
            ->add('is_blackpowder', ChoiceType::class, array(
                'required' => true,
                'choices' => ['No' => 0, 'Yes' => 1],
                'expanded' => true,
                'label' => 'Is your weapon blackpowder?'
            ))
            ->add('ammunition_type', ChoiceType::class, array(
                'choices' => $options['dictionary']['ammunitionTypes'],
                'label' => 'Ammunition type'
            ))
            ->add('gun_type', ChoiceType::class, array(
                'choices' => $options['dictionary']['gunTypes'],
                'label' => 'Gun type',
                'expanded' => true
            ))
            ->add('reload_type', ChoiceType::class, array(
                'choices' => $options['dictionary']['reloadTypes'],
                'label' => 'Reload types'
            ))
            ->add('lock_type', ChoiceType::class, array(
                'choices' => $options['dictionary']['lockTypes'],
                'label' => 'Lock type'
            ))
            ->add('caliber_type', ChoiceType::class, array(
                'choices' => $options['dictionary']['caliberTypes'],
                'label' => 'Caliber type'
            ))
            ->add('permission', ChoiceType::class, array(
                'required' => true,
                'choices' => ['No' => 0, 'Yes' => 1],
                'expanded' => true,
                'label' => 'Is your weapon blackpowder?'
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'dictionary' => []
        ]);
    }

    public function getDefaultOptions(array $options)
    {
        return [
            'test' => false
        ];
    }

    public function getBlockPrefix()
    {
        return 'register_type';
    }
}