<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Entity\AvisSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

     /**
      * @return Avis[] Returns an array of Avis objects
      */
    public function findByArticleId($id)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.produit = :val')
            ->setParameter('val', $id)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Query
     */
   public function findAllByArticleIdQuery($id): Query
   {
       return $this->findByArticleIdQuery($id)->getQuery();

   }

   /**
    * @return Query
    */
  public function findByArticleIdQuery($id,AvisSearch $search)
  {
      $query = $this->createQueryBuilder('a')
          ->andWhere('a.produit = :val')
          ->setParameter('val', $id);

      if($search->getMinNote()) {
        $query = $query
          ->andWhere('a.note >= :note')
          ->setParameter('note', $search->getMinNote());
      }

      return $query->orderBy('a.id', 'ASC')->getQuery();
;

  }

    /*
    public function findOneBySomeField($value): ?Avis
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
