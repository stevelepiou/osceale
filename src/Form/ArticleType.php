<?php

namespace App\Form;

use App\Entity\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class,[
                'attr' =>[
                    'class' => 'form-control input_article'
                ],
                'label'=>'Titre de l\'article',
                'label_attr'=>[
                    'class'=>'form-label mt-4 label_article'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2,'max'=>20]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Description', TextType::class,[
                'attr' =>[
                    'class' => 'form-control input_article'
                ],
                'label'=>'Description de l\'article',
                'label_attr'=>[
                    'class'=>'form-label mt-4 label_article'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2,'max'=>255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Contenu', TextType::class,[
                'attr' =>[
                    'class' => 'form-control input_article'
                ],
                'label'=>'Contenu de l\'article',
                'label_attr'=>[
                    'class'=>'form-label mt-4 label_article'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2,'max'=>1000]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('imageFile',VichImageType::class, [
                'label' => 'Image de l\'article',
                'label_attr' => [
                    'class' =>'form-label mt-4 label_article'
                ],
                'attr' =>[
                    'class'=>'image_article'
                ]
            ])
            // ->add('image', TextType::class,[
            //     'attr' =>[
            //         'class' => 'form-control'
            //     ],
            //     'label'=>'Image de l\'article',
            //     'label_attr'=>[
            //         'class'=>'form-label mt-4'
            //     ]
            // ])
            ->add('Submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary mt-4 btn_article'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
