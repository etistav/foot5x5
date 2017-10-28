<?php
// src/foot5x5/UserBundle/Controller/SecurityController.php

namespace foot5x5\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction() {

        // Si le visiteur est déjà identifié, on le redirige vers la page d'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('foot5x5_main_homepage'));
        }

        $request = $this->getRequest();
        $session = $request->getSession();

        // Vérification d'éventuelles erreurs lors d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->has(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('foot5x5UserBundle:Security:login.html.twig', array(
                // Valeur du précédent nom d'utilisateur entré par l'internaute
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error
            )
        );
    }
}
