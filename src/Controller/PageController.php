<?php

namespace App\Controller;

use App\Entity\Entry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\EntryService;

/**
 * Description of DefaultController
 *
 * @author valera261104
 */
class PageController extends AbstractController {

    public function index() {

        try {

            $data = (new EntryService($this->getDoctrine()->getManager()))->getList();

            var_dump($data);

            return $this->render('index.html.twig', [
                        'list' => $list]);
        } catch (\Throwable $e) {

            die($e->getMessage());
        }
    }

}
