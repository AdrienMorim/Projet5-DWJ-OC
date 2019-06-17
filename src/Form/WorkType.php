<?php

namespace App\Form;

use App\Entity\Work;
use App\Form\ImageType;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subtitle')
            ->add('content')
            ->add('link')
            ->add('categories', EntityType::class, [ // On précise d'où vient les catégories
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false // A utilisé pour que addCategory() / removeCategory() soient appelés comme categories est un ArrayCollection()
            ])
            ->add('image', ImageType::class, [
                'label' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Work::class
        ]);
    }
}
