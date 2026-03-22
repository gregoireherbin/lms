<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur'=> 'ROLE_ADMIN',
                    'Formateur' => 'ROLE_FORMATEUR',
                    'Etudiant' => 'ROLE_ETUDIANT',
                ],
                'multiple' => true,
                'expanded' => false,
            ])

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false, // Important : on ne mappe pas sur l'entité
                'required' => true,
            ])
            ->add('Nom')
            ->add('Prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
