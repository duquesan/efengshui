<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormView;


class UserSubsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', Type\TextType::class, ["attr"=> ["placeholder" => "Entrez votre nom"]])
            ->add('prenom', Type\TextType::class, ["label"=>"Prénom","attr"=> ["placeholder" => "Entrez votre prénom"]])
            ->add('email', Type\TextType::class, ["attr"=> ["placeholder" => "Entrez votre adresse mail"]])
            ->add('password', PasswordType::class, ["label"=>"Mot de passe","help"=>"Votre mot de passe doit contenir au moins 6 caractères","attr"=>["placeholder" => "Entrez votre mot de passe"],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre motde passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('conditions', CheckboxType::class, [ "label"=>"J'accepte les conditions générales du site",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Veuillez accepter les conditions afin de valider votre inscription",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}