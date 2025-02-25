<?php

namespace App\Form;

use App\Entity\TypeVehicle;
use App\Entity\Vehicle;
use App\Entity\Characteristic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ModifyVehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image')
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 100]),
                ],
            ])
            ->add('capacity', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 1, 'max' => 9]),
                ],
            ])
            ->add('price', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0.01]),
                ],
            ])
            ->add('typeVehicle', EntityType::class, [
                'class' => TypeVehicle::class,
                'choice_label' => 'id',
            ])
            ->add('characteristics', EntityType::class, [
                'class'        => Characteristic::class,
                'choice_label' => 'name',
                'multiple'     => true,
                'expanded'     => true,
            ])
        ;

        // Add validation for required characteristics
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $vehicle = $event->getData();
            $form = $event->getForm();

            if (!$vehicle || null === $vehicle->getTypeVehicle()) {
                return;
            }

            $typeName = $vehicle->getTypeVehicle()->getName();
            $characteristics = $vehicle->getCharacteristics();
            $hasCharacteristic = function ($name) use ($characteristics) {
                foreach ($characteristics as $char) {
                    if ($char->getName() === $name) {
                        return true;
                    }
                }
                return false;
            };

            if ($typeName === 'Électrique' && !$hasCharacteristic('Recharge rapide')) {
                $form->get('characteristics')->addError(new FormError("La caractéristique 'Recharge rapide' est obligatoire pour les véhicules électriques."));
            }

            if ($typeName === 'Tout-terrain' && !$hasCharacteristic('4x4')) {
                $form->get('characteristics')->addError(new FormError("La caractéristique '4x4' est obligatoire pour les véhicules tout-terrain."));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
