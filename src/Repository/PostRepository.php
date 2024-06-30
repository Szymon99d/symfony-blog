<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
        $this->paginator = $paginator;
    }
    
    public function findAllPaginated(int $page, int $limit = 5)
    {
        $query = $this->createQueryBuilder('p')->getQuery();
        return $this->paginator->paginate($query, $page, $limit, ['defaultSortFieldName' => 'p.dateEntered', 'defaultSortDirection' => 'DESC']);
    }

    public function findPublishedPaginated(int $page, int $limit = 5)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.published = true')
            ->getQuery();
        return $this->paginator->paginate($query, $page, $limit, ['defaultSortFieldName' => 'p.dateEntered', 'defaultSortDirection' => 'DESC']);
    }

    public function findAllPaginatedByCategory(int $page, Category $category)
    {
        $query = $this->createQueryBuilder('p')
            ->join('p.category', 'r')
            ->where('r.id = :cid')
            ->setParameter('cid', $category->getId())
            ->getQuery();
        return $this->paginator->paginate($query, $page, 5, ['defaultSortFieldName' => 'p.dateEntered', 'defaultSortDirection' => 'DESC']);
    }
}
