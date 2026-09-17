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
            ->add('Nom')
            ->add('Prenom')
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false, // Important : on ne mappe pas sur l'entité
                'required' => true,
            ]);
        if ($options['is_admin_form'] ?? false) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Formateur' => 'ROLE_FORMATEUR',
                    'Etudiant' => 'ROLE_ETUDIANT',
                ],
                'multiple' => true,
                'expanded' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_admin_form' => false, // option par défaut
        ]);
    }
}
