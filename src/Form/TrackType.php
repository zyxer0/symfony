<?php


namespace App\Form;


use App\Entity\ShortUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class TrackType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ShortUrl', TextType::class, [
                'attr' => ['autofocus' => true],
                'label' => 'label.long_url',
                'required' => true,
            ])
            ->add('search', SubmitType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var $shortUrl ShortUrl */
                $data = $event->getData();

                if (!empty($data['ShortUrl'])) {
                    $data['ShortUrl'] = trim(parse_url($data['ShortUrl'], PHP_URL_PATH), '/');
                }

                $event->setData($data);
            });
    }
}
