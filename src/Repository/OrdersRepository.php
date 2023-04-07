<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    /**
     * Sipariş ekler
     * @param string $orderCode
     * @param int $productid
     * @param int $quantity
     * @param string $address
     * @param $shippingDate
     * @return void
     */
    public function addOrders(string $orderCode, int $productid, int $quantity, string $address, $shippingDate = null) : void
    {
        $order = new Orders();
        $order
            ->setOrderCode($orderCode)
            ->setProductid($productid)
            ->setQuantity($quantity)
            ->setAddress($address)
            ->setShippingDate($shippingDate ?: null);
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * Sipariş günceller
     * @param Orders $order
     * @param $shippingDate
     * @return void
     */
    public function updateOrders(Orders $order, $shippingDate) : void
    {
        $set = $order
            ->setShippingDate($shippingDate);
        $this->getEntityManager()->persist($set);
        $this->getEntityManager()->flush();
    }

    /**
     * Tekli sipariş getirir
     * @param string $code
     * @return mixed
     */
    public function get(string $code)
    {
        return $this->findOneBy(['orderCode' => $code]);
    }

    /**
     * Bütün siparişleri getirir
     * @return mixed
     */
    public function getAll()
    {
        return $this->findAll();
    }
}
