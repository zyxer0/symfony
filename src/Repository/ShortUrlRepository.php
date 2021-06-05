<?php


namespace App\Repository;


use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }
    
    public function findByShortUrl22($shortUrl): string
    {
        $entityManager = $this->getEntityManager();
        
        do {

            $shortUrl = '';
            for ($i = 0; $i < 10; $i++) {
                $ranges = [
                    rand(48, 57),
                    rand(65, 90),
                    rand(97, 122),
                ];
                $shortUrl .= chr($ranges[rand(0, 2)]);
            }
            
            $query = $entityManager->createQuery(
                '
            SELECT su.short_url
            FROM App\Entity\ShortUrl su
            WHERE short_url = :short_url
            LIMIT 1
            '
            )->setParameter('short_url', $shortUrl);
        } while ($query->getResult());
        
        return $shortUrl;
    }
    
}