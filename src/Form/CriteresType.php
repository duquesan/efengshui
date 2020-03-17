<?php

namespace App\Form;

use App\Entity\Criteres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
//Permet d'utiliser la class Type et d'ajouter automatiquement les types dont j'ai besoin. (Comme pour le Type\TextType::class plus bas)
use Symfony\Component\Validator\Constraints;
//Permet d'utiliser les contraintes



class CriteresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_diagnostic', Type\TextType::class, ["attr"=> ["placeholder" => "Veuillez entrer le titre de votre diagnostic."], "label" => "Titre de votre diagnostic"])
            ->add('nb_m_carre', Type\TextType::class, ["label" => "Combien de surface possédez-vous?"])
            ->add('lieu', Type\ChoiceType::class, ["attr"=>['class' => 'choixLieu'], 'choices' => ['Bureau' => 'bureau', 'Domicile' => 'domicile'],           
            'expanded' => true,
            'multiple' => false])
            ->add('annee_constr', Type\TextType::class, ["label" => "Quelle est l'année de construction de votre immeuble?"])
            ->add('plan_lieu', Type\TextType::class, ["label" => "Téléchargez le plan de votre immeuble."])
            ->add('photo_lieu', Type\TextType::class,["label" => "Téléchargez les photos de votre appartement."])
            ->add('orientation', Type\TextType::class, ["label" => "Veuillez sélectionner l'orientation de votre immeuble."])
            ->add('user', EntityType::class, [ "class" => User::class, "choice_label" => function(User $user){
                return $user->getId();
            }
            ])
            ->add('ajouter', Type\SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Criteres::class,
        ]);
    }
}
