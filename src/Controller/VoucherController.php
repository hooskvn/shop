<?php

namespace App\Controller;

use App\Entity\Voucher;
use App\Repository\VoucherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoucherController extends AbstractController
{
    #[Route('/voucher/add', name: 'create_voucher', methods: 'POST')]
    public function createProduct(
        VoucherRepository $voucherRepository,
        Request $request
        ): Response
    {
        $data = json_decode($request->getContent(), true);

        $voucher = new Voucher();
        $voucher->setTitle($data['title']);
        $voucher->setCode($data['code']);
        $voucher->setType($data['type']);
        $voucher->setAmount($data['amount']);

        $voucherRepository->add($voucher, true);

        return new Response(
            sprintf(
                'Saved new voucher with id #%d',
                $voucher->getId()
            ),
            Response::HTTP_OK
        );
    }

    #[Route('/vouchers', name: 'get_vouchers', methods: 'GET')]
    public function getProducts(VoucherRepository $voucherRepository): Response
    {
        $vouchers = $voucherRepository->findAll();
        $vouchersList = [];

        foreach ($vouchers as $voucher) {
            $vouchersList[] = [
                'id' => $voucher->getId(),
                'title' => $voucher->getTitle(),
                'code' => $voucher->getCode(),
                'type' => $voucher->getType(),
                'amount' => $voucher->getAmount(),
            ];
        }

        return new Response(json_encode($vouchersList), Response::HTTP_OK);
    }
}
