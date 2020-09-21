<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use ContainerBuEoMCl\getFosCkEditor_Form_TypeService;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Titre de l'évènement"
            ])
            ->add('description', CkeditorType::class, [
                'label' => "Description de l'évènement"
            ])
            // ->add('coverImage', TextType::class,[
            //     'label' => 'Image de couverture'
            // ])
            ->add('imageFile', VichImageType::class, [
                
            ])
            ->add('startEvent', DateTimeType::class, [
                'label' => 'Début le:'])
            ->add('endEvent', DateTimeType::class, [
                'label' => 'Fin le:'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
