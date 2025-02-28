<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEditBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('publicationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                        "Science-Fiction" => "Science-Fiction",
                        "Mystery" => "Mystery",
                        "Autobiography" => "Autobiography"
                ]
            ])
            ->add('enabled')
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'username',
            ])
            ->add('Send', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
