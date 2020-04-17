<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }






    public function findByFilter($data)
    {

        $qb = $this->createQueryBuilder('p');
        if (isset($data['searchbar'])) {
            $qb=$qb->andWhere('p.name LIKE :name')
                ->setParameter('name', "%".$data['searchbar']."%");
        }
        if (isset($data['category'])) {
            $qb=$qb->andWhere('p.category = :val')
                ->setParameter('val', $data['category']);
        }
        if (isset($data['minPrice'])) {
            $qb= $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $data['minPrice']);
        }
        if (isset($data['maxPrice'])) {
            $qb= $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $data['maxPrice']);
        }
       


        return $qb->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
