<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchProductData;

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

    public function searchProduct(SearchProductData $search)
    {
        $query = $this
            ->createQueryBuilder('product')
            ->from($this->_entityName, 'p')
            ->innerJoin('product.category', 'category')
            ->leftJoin('product.gender', 'gender');

        if (!empty($search->category)) {
            $query = $query
                ->andWhere('category.id IN (:category)')
                ->setParameter('category', $search->category);
        }

        if (!empty($search->gender)) {
            $query = $query
                ->andWhere('gender.id IN (:gender)')
                ->setParameter('gender', $search->gender);
        }

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('product.name LIKE :q 
                OR product.description LIKE :q
                OR category.name LIKE :q
                OR gender.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        $query = $query->getQuery()->getResult();
        return $query;
    }

}
