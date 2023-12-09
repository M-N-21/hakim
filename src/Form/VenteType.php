<?php

namespace App\Form;

use App\Entity\Gerant;
use App\Entity\Produit;
use App\Entity\Vente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateVente')
            ->add('quantiteVente')
            ->add('prixVente')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
'choice_label' => 'id',
            ])
            ->add('gerant', EntityType::class, [
                'class' => Gerant::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
