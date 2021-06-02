<?php


namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="short_urls")
 * UniqueEntity(fields={"slug"}, errorPath="title", message="post.slug_unique")
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
     * @ORM\Column(type="string")
     */
    private $longUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $shortUrl;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expiration;


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

    public function getExpiration(): ?DateTime
    {
        return $this->expiration;
    }

    public function setExpiration(?string $expiration): void
    {
        $this->expiration = $expiration;
    }
    
    
}