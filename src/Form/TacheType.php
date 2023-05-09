<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class,[
                'attr' =>[
                    'class' => 'form-control'
                ],
                'label'=>'Titre de la tâche',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2,'max'=>50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextType::class,[
                'attr' =>[
                    'class' => 'form-control'
                ],
                'label'=>'Description de la tâche',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2,'max'=>255])
                ]
            ])
            ->add('Submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary mt-4'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
