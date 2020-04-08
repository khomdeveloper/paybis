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

        $list = (new EntryService($this->getDoctrine()->getManager()))->getList();
        return $this->render('index.html.twig', [
                    'list' => $list]);
    }

    public function login() {

        return $this->render('login.html.twig');
    }

}
