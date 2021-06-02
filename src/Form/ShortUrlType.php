<?php


namespace App\Form;


use App\Entity\ShortUrl;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;


class ShortUrlType extends AbstractType
{
    private $slugger;

    // Form types are services, so you can inject other services in them if needed
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LongUrl', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.long_url',
            ])
            ->add('expiration', DateTimePickerType::class, [
                'attr' => ['class' => 'js-datepicker'],
//                'widget' => 'choice',
                'label' => 'label.expiration',
                'help' => 'help.expiration',
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var $shortUrl ShortUrl */
                $shortUrl = $event->getData();
                var_dump($shortUrl->getLongUrl());
                
                if (null !== $postTitle = $shortUrl->getShortUrl()) { // todo здесь генерить уникальный урл
                    $shortUrl->setShortUrl($this->slugger->slug($postTitle)->lower());
                }
            });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortUrl::class,
        ]);
    }
}
