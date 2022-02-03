<?php

namespace App\Form;

use App\Entity\Vin;
use App\Entity\Region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VinType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du vin'])
            ->add('millesime', IntegerType::class, ['label' => 'Millésime'])
            ->add('robe', ChoiceType::class, [
                'label' => 'Type du vin',
                    'choices' => [
                        'Vin rouge' => 'rouge',
                        'Vin blanc' => 'blanc',
                        'Vin rosé' => 'rosé',
                    ]
                
            ])

            ->add('imageFile', VichImageType::class)

            ->add('qtt_stock', IntegerType::class, [
                'label'=> 'quantité en stock',
                'data' => 1
                ])
            ->add('contenance', TextType::class, ['label' => 'Contenance'])
            ->add('remarques', TextareaType::class, [
                'label' => 'Vos remarques',
                'required' => false,
                ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'label' => ''
                ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
