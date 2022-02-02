<?php

namespace App\Controller;

use App\Repository\VinRepository;
use App\Service\MessageGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class HomeController extends AbstractController
{

    // #[Route('/', name: 'home')]
    // public function home(VinRepository $repo): Response
    // {
    //     $stock = $repo->nbrVinEnCave();
    //     return $this->render('home/home.html.twig', [
    //         'nbr_vins' => $stock
    //     ]);
    // }

    // Permet de récupérer la quantité de bouteille par Robe
    // #[Route('/', name: 'home')]
    // public function home(VinRepository $repo): Response
    // {
    //     $stock = $repo->nbrVinEnCaveByRobe('blanc');
    //     return $this->render('home/home.html.twig', [
    //         'nbr_vins' => $stock
    //     ]);
    // }

    #[Route('/', name: 'home')]
    public function home(VinRepository $repo, MessageGenerator $msgGen): Response
    {
        $msg = $msgGen->getMessage('loginOk');
        $this->addFlash('notif', $msg);
        // $stock = $repo->nbrVinEnCave();
        // $stockBlanc = $repo->nbrVinEnCaveByRobe('blanc');
        // $stockRouge = $repo->nbrVinEnCaveByRobe('rouge');
        // $stockRose = $repo->nbrVinEnCaveByRobe('rosé');
        $stocks = $repo->stock();
        return $this->render('home/home.html.twig', [
            'stocks' => $stocks,
            // 'nbr_vins' => $stock,
            // 'stock_blanc' => $stockBlanc,
            // 'stock_rouge' => $stockRouge,
            // 'stock_rose' => $stockRose,
        ]);
    }


}
