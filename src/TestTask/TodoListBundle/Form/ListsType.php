<?php

namespace TestTask\TodoListBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
                'attr' => array(
                    'maxlength' => '100',
                    'placeholder' => 'Добавить список',
                )))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TestTask\TodoListBundle\Entity\Lists'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'add_list';
    }
}