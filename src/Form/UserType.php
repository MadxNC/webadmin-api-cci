<?php
namespace App\Form;

use App\Entity\User;
use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['entity_manager'];

        $roles = array();

        $repository = $entityManager->getRepository(Groupe::class);
        $groups = $repository->findAll();
        foreach ($groups as $group) {
            $roles[$group->getName()] =  $group->getRole();
        }

        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'utilisateur*'
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identiques',
                'first_options'  => array('label' => 'Mot de passe*'),
                'second_options' => array('label' => 'Répéter le mot de passe*'),
            ))
            ->add('roles', ChoiceType::class, array(
                'choices' => $roles,
                'multiple' => true,
                'label' => 'Choix du role*'
            ))
            ->add('isActive', CheckboxType::class, array(
                'label'    => 'Actif ?',
                'required' => false
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom de famille',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse email',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('telephone', TelType::class, array(
                'label' => 'Téléphone',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('societe', TextType::class, array(
                'label' => 'Société / Entreprise',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('fonction', TextType::class, array(
                'label' => 'Fonction / Métier',
                'required' => false,
                'empty_data' => ''
            ))
            ->add('avatar', TextType::class, array(
                'label' => 'Lien vers la photo de profil',
                'required' => false,
                'empty_data' => ''
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
        $resolver->setRequired('entity_manager');
    }
}