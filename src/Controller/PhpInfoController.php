<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhpInfoController extends AbstractController
{
    /**
     * @Route("/phpinfo", name="app_php_info")
     */
    public function index(): Response
    {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();
        return $this->render('php_info/index.html.twig', array(
            'phpinfo'=>$phpinfo,
        ));
        return new Response(phpinfo());
    }
}
