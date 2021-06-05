<?php


namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortUrlRepository")
 * @ORM\Table(name="short_urls")
 * @UniqueEntity(fields={"shortUrl"}, message="post.slug_unique")
 * @ORM\Entity
 *
 */
class ShortUrl
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2048)
     * @Assert\Url(message="error.wrong_long_url")
     * @Assert\NotBlank(message="error.wrong_long_url")
     * @Assert\Length(max=2048)
     */
    private $longUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $shortUrl;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expiration;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $usages;

    public function __construct()
    {
        $this->expiration = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    public function setLongUrl(?string $longUrl): void
    {
        $this->longUrl = $longUrl;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(?string $shortUrl): void
    {
        $this->shortUrl = $shortUrl;
    }

    public function getExpiration(): DateTime
    {
        return $this->expiration;
    }

    public function setExpiration(DateTime $expiration): void
    {
        $this->expiration = $expiration;
    }

    public function getUsages(): int
    {
        return $this->usages;
    }

    public function setUsages(int $usages): void
    {
        $this->usages = $usages;
    }
}