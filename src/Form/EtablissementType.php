<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Etablissement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'établissement"
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
                
            ])
            // ->add('lat')
            // ->add('lng')
            // ->add('coverImage', TextType::class, [
            //     'label' => 'Image de couverture'
            // ])

            ->add('imageFile', VichImageType::class, [
                
                ])
                
            ->add('category', EntityType::class, [
                'label' => "Catégorie",
                'class' => Category::class,
                'choice_label' => 'name',


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
