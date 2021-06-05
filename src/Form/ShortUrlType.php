<?php


namespace App\Form;


use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;


class ShortUrlType extends AbstractType
{
    private $slugger;
    private $managerRegistry;

    public function __construct(SluggerInterface $slugger, ManagerRegistry $managerRegistry)
    {
        $this->slugger = $slugger;
        $this->managerRegistry = $managerRegistry;
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
//                'required' => true,
            ])
            ->add('expiration', DateTimeType::class, [
//                'attr' => ['class' => 'js-datepicker'],
                'widget' => 'single_text',
                'label' => 'label.expiration',
                'help' => 'help.expiration',
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var $shortUrl ShortUrl */
                $shortUrl = $event->getData();
                
                /** @var ShortUrlRepository $er */
                $er = $this->managerRegistry->getRepository(ShortUrl::class);

                // Generate new unique short url
                do {
                    $newShortUrl = '';
                    for ($i = 0; $i < 10; $i++) {
                        $ranges = [
                            rand(48, 57),
                            rand(65, 90),
                            rand(97, 122),
                        ];
                        $newShortUrl .= chr($ranges[rand(0, 2)]);
                    }
                } while ($er->findByShortUrl($newShortUrl)); // todo здесь добавить проверку по дате
                $shortUrl->setShortUrl($newShortUrl);
                $shortUrl->setUsages(0);
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
