<?php

namespace LivrariaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProdutosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nome')
                ->add('quantidade')
                ->add('preco')
                ->add('tipo', ChoiceType::class, array(
                    "choices" => array(
                        "Livro" => "Livro",
                        "Revista" => "Revista"
                    )
                ))
                ->add('imagem')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LivrariaBundle\Entity\Produtos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'livrariabundle_produtos';
    }


}
