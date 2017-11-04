<?php
// src/foot5x5/UserBundle/Controller/SecurityController.php

namespace foot5x5\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
	/**
	 * Handle the 'login' view
	 *
	 * @param Request $request
	 */
    public function loginAction(Request $request) {

        // Si le visiteur est déjà identifié, on le redirige vers la page d'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('foot5x5_main_homepage'));
        }
        
        $session = $request->getSession();

        // Vérification d'éventuelles erreurs lors d'une précédente soumission du formulaire
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->has(Security::AUTHENTICATION_ERROR);
        } else {
        	    $error = $session->get(Security::AUTHENTICATION_ERROR);
        	    $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('foot5x5UserBundle:Security:login.html.twig', array(
                // Valeur du précédent nom d'utilisateur entré par l'internaute
        		    'last_username' => $session->get(Security::LAST_USERNAME),
                'error'         => $error
            )
        );
    }
}
