<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class ,array(
                'label' => 'Nom du groupe',
                'attr' => array(
                    'placeholder' => 'Manager, Modérateur'
                )
            ))
            ->add('role', TextType::class, array(
                'label' => 'Nom du role',
                'attr' => array(
                    'placeholder' => 'ROLE_MANAGER, ROLE_MODERATEUR'
                ),
                'help' => 'Inclure le prefixe "ROLE_" et tout en majuscule'
            ))
            ->add('niveau', NumberType::class, array(
                'label'     => 'Niveau'
            ))
            ->add('isActive', CheckboxType::class, array(
                'label' => 'Actif ?',

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
