<?php

namespace App\Controller;

use App\Form\MyProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MyProfileController extends AbstractController
{
    /**
     * @Route("/myprofile", name="myProfile")
     */
    public function myProfile(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $memberForm = $this->createForm(MyProfileType::class, $user);

        $memberForm->handleRequest($request);

        if($memberForm->isSubmitted() && $memberForm->isValid()){
            $this->addFlash('success', 'Modifications enregistrées !');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('my_profile/myProfile.html.twig', [
            'myProfileFormView' => $memberForm->createView(),
        ]);
    }


}
