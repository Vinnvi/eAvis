<?php

namespace App\Form;

use App\Entity\AvisSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AvisSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minNote', IntegerType::class, [
              'required' => false,
              'label' => 'Filtrer la note minimale',
              'attr' => [
                'placeholder' => 'Note minimale'
              ]
            ])
            ->add('submit', SubmitType::class, [
              'label' => 'filtrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AvisSearch::class,
            'method' => 'get',
            'csrf_protect' => false
        ]);
    }
}
