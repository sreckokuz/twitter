<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label'=>false, 'attr' => ['placeholder' => 'Username']])
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => ['label'=>false, 'attr' => ['placeholder' => 'Password']],
                'second_options' => ['label'=>false, 'attr' => ['placeholder' => 'Repated password']]
            ] )
            ->add('email', EmailType::class, ['label'=>false, 'attr' => ['placeholder' => 'E-mail']])
            ->add('fullName', TextType::class, ['label'=>false, 'attr' => ['placeholder' => 'Full name']])
            ->add('termsAgreed', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue(),
                'label' => 'I agree to the Terms of Service'
            ])
            ->add('Register', SubmitType::class, ['attr' => ['placeholder' => 'Full name', 'data-loading-text' => "<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order"]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
