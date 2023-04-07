<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */

class OrdersController extends AbstractController
{
    private OrdersRepository $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * @Route("/orders/add", name="orders_add", methods={"POST"})
     */
    public function add(Request $request): Response
    {

        $data = json_decode($request->getContent());

        if (empty($data->orderCode) || empty($data->productid) || empty($data->quantity) || empty($data->address)) {
            return new JsonResponse(['status' => 'Zorunlu alanlar girilmelidir.'], Response::HTTP_NO_CONTENT);
        }

        $get = $this->ordersRepository->findOneBy(['orderCode' => $data->orderCode]);

        /*
         * Sipariş kayıtlı
         */
        if (!empty($get)) {
            return new JsonResponse(['status' => 'Sipariş kodu zaten kayıtlı'], Response::HTTP_OK);
        }

        $this->ordersRepository->addOrders($data->orderCode, $data->productid, $data->quantity, $data->address, $data->shippingDate ?? '');

        return new JsonResponse(['status' => 'Sipariş başarıyla eklendi.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/orders/update", name="orders_update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {

        $data = json_decode($request->getContent());

        if (empty($data->orderCode) || empty($data->shippingDate)) {
            return new JsonResponse(['status' => 'Zorunlu alanlar girilmelidir.'], Response::HTTP_NO_CONTENT);
        }

        $get = $this->ordersRepository->findOneBy(['orderCode' => $data->orderCode]);

        /*
         * Sipariş bulunamadı
         */
        if (empty($get)) {
            return new JsonResponse(['status' => 'Sipariş bulunamadı'], Response::HTTP_OK);
        }

        if ($get->getShippingDate() !== null) {
            return new JsonResponse(['status' => 'Sipariş güncellenemez'], Response::HTTP_OK);
        }

        $shippingDate = new \DateTime($data->shippingDate);

        $this->ordersRepository->updateOrders($get, $shippingDate);

        return new JsonResponse(['status' => 'Sipariş başarıyla güncellendi.'], Response::HTTP_OK);
    }
    /**
     * @Route("/orders/{code}", name="orders_get", methods={"GET"})
     */
    public function get($code = null): JsonResponse
    {
        $data = [];
        if ($code === null) {
            $get = $this->ordersRepository->getAll();
            if (empty($get)) {
                return new JsonResponse(['status' => 'Sipariş verisi bulunamadı.'], Response::HTTP_NOT_FOUND);
            }
            foreach ($get as $item) {
                $data[] = $item->toArray();
            }
        } else {
            $get = $this->ordersRepository->get($code);
            if (empty($get)) {
                return new JsonResponse(['status' => 'Sipariş koduna ait veri bulunamadı.'], Response::HTTP_NOT_FOUND);
            }
            $data = $get->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}