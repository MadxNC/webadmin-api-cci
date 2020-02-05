<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BooleanType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $entityManager = $options['entity_manager'];
        $repository = $entityManager->getRepository(Menu::class);
        $menus = $repository->findAll();

        $groupes = $entityManager->createQuery('SELECT g FROM App\Entity\Groupe g WHERE g.role <> \'ROLE_ADMIN\' ORDER BY g.name ASC')->execute();

        $builder
            ->add('name', TextType::class, array(
                'label' => 'Libelle du menu',
                'required' => true
            ))
            ->add('title', TextType::class, array(
                'label' => 'Titre de page du menu',
                'help' => 'Le titre est le texte présente dans l\'entête de la page',
                'required' => false
            ))
            ->add('route', TextType::class, array(
                'label' => 'Nom de la route associée',
                'help' => 'Pour un menu non cliquable, ne rien mettre. Route désactivée si ce menu est parent d\'un autre menu',
                'required' => false
            ))
            ->add('icon', TextType::class, array(
                'label' => 'Icône associé',
                'help' => 'Donner toutes les classes de l\'icône',
                'attr' => array(
                    'placeholder' => 'fa fa-user / flaticon-user / la la-user'
                    ),
                'required' => false

            ))
            ->add('position', NumberType::class, array(
                'label' => 'Position du menu',
                'required' => false
            ))
            ->add('parent', EntityType::class, array(
                'class' => Menu::class,
                'label' => 'Menu parent',
                'choice_label' => 'name',
                'choices' => $menus,
                'required' => false,
                'multiple' => false,
                'placeholder' => 'Choisir un parent',
                'help' => 'Si un parent est choisi, la route associée du parent (si il y en a une) ne sera pas active.'
            ))
            ->add('groupe', EntityType::class, array(
                'class' => Groupe::class,
                'label' => 'Groupe(s)',
                'choice_label' => 'name',
                'choices' => $groupes,
                'required' => false,
                'multiple' => true,
                'placeholder' => 'Choisir le(s) groupe(s)',
                'help' => 'Choisir le ou les groupes qui peuvent voir ce menu'
            ))
            ->add('isActive', CheckboxType::class, array(
                'label' => 'Actif ?',
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
        $resolver->setRequired('entity_manager');

    }
}
