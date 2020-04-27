<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Employe;
use App\Entity\Projet;
use App\Entity\Seminaire;
use App\Entity\Theme;
use App\Form\CoursType;
use App\Form\SeminaireType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequeteController extends AbstractController
{

    /**
    *@Route("/webHook", name="webHook")
    */
    public function webHook() {
       $contents = file_get_contents('deploy.sh');
       echo shell_exec($contents);
       //echo shell_exec('sh deploy.sh');
       //exec("touch jeSuisBinNotifier.txt");
       return new Response($contents);
     }


    /**
     * @Route("/TousProjets", name="TousProjets")
     */
    public function tousProjetAction(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Projet::class);
        $projets = $repo->findAll();

        return $this->render('requete/index.html.twig', [
            'projets' => $projets,
        ]);
    }


    /**
     * @Route("/unCours/{id}", name="unCours", requirements={"id" : "\d+"})
     */
    public function unCours(EntityManagerInterface $em, int $id)
    {
        $repo = $em->getRepository(Cours::class);
        $cours = $repo->find($id);

        return $this->render('requete/cours.html.twig', [
            'cours' => $cours,
        ]);
    }


    /**
     * @Route ("/coursNbJours/{nb}", name="coursNbJours", requirements={"nb" : "\d+"})
     * @param EntityManagerInterface $em
     * @param int $nb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coursNbJours(EntityManagerInterface $em, int $nb = 4) {
        $repo = $em->getRepository(Cours::class);
        $cours = $repo->findBy(["nbJours" => $nb]);

        return $this->render("requete/cherchenbcours.html.twig", [
            'cours' => $cours
        ]);
    }

    /**
     * @Route ("/employeVilleProjet/{ville}/{id}", name="employeVilleProjet",
     *     requirements={"ville" : "[A-Z][a-zàéèêçîôö]*", "id": "\d+"},
     *     options={"utf8": true})
     * @param EntityManagerInterface $em
     * @param int $nb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function employeVilleProjet(EntityManagerInterface $em, string $ville, int $id) {
        $repo = $em->getRepository(Employe::class);
        $criteres = ["ville" => $ville, "projet" => $id];

        $employes = $repo->findBy($criteres);

        return $this->render("requete/employeVilleProjet.html.twig", [
            'employes' => $employes
        ]);
    }

    /**
     * @Route ("/employeSalaireSuperieur/{salaire}", name="employeSalaireSuperieur")
     * @param float $salaire
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function employeSalaireSuperieur(float $salaire) {
        $employes = $this
            ->getDoctrine()
            ->getRepository(Employe::class)
            ->getSalaireSuperieur($salaire);
        return $this->render("requete/employeSalaireSuperieur.html.twig", [
            'employes' => $employes
        ]);
    }


    /**
     * @Route("/SeminairesCours", name="SeminairesCours")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function SeminairesCours() {

        $seminaires = $this->getDoctrine()->getRepository(Seminaire::class)->getSeminairesCours();
        return $this->render("requete/SeminairesCours.html.twig", [
            'seminaires' => $seminaires
        ]);
    }

    /**
     * @Route("/seminaireInscrits/{id}", name="seminaireInscrits")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seminaireInscrits(EntityManagerInterface $em, int $id) {
        $repo = $em->getRepository(Seminaire::class);
        //$employes = $this->getDoctrine()->getRepository(Employe::class)->getSeminaireInscrits($id);
        $seminaire = $repo->find($id);
        $employes = $seminaire->getEmployes();
        return $this->render("requete/seminaireInscrits.html.twig", [
            'seminaire' => $seminaire,
            'employes' => $employes
        ]);

    }

    /**
     * @Route("/", name="seminaireNbInscrits")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seminaireNbInscrits(EntityManagerInterface $em) {
        $repo = $em->getRepository(Seminaire::class);
        //$employes = $this->getDoctrine()->getRepository(Employe::class)->getSeminaireInscrits($id);
        $seminaires = $repo->findAll();
        return $this->render("requete/seminaireNbInscrits.html.twig", [
            'seminaires' => $seminaires
        ]);
    }

    /**
     * @Route("/ProjetNbEmployes", name="ProjetNbEmployes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ProjetNbEmployes(EntityManagerInterface $em) {
        $repo = $em->getRepository(Projet::class);
        //$employes = $this->getDoctrine()->getRepository(Employe::class)->getSeminaireInscrits($id);
        $projets = $repo->findAll();
        return $this->render("requete/ProjetNbEmployes.html.twig", [
            'projets' => $projets
        ]);
    }

    /**
     * @Route("/creerCours", name="creerCours")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function creerCours(Request $request, ManagerRegistry $doctrine) {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cours = $form->getData();
            $e = $doctrine->getManager();
            $e->persist($cours);
            $e->flush();
            return $this->redirectToRoute('creationCoursOk', ["id" => $cours->getId()]);
        }
        return $this->render('requete/cours.html.twig', [
            'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/creationCoursOk/{id}", name="creationCoursOk")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function creationCoursOk(EntityManagerInterface $em, int $id) {

        $repo = $em->getRepository(Cours::class);
        $cours = $repo->find($id);
        return $this->render('requete/creationCoursOk.html.twig', [
            'cours' => $cours
        ]);
    }

    /**
     * @Route("creerSeminaire", name="creerSeminaire")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creerSeminaire(Request $request, ManagerRegistry $doctrine) {

        $seminaire = new Seminaire();
        $form = $this->createForm(SeminaireType::class, $seminaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $seminaire = $form->getData();
            $e = $doctrine->getManager();
            $e->persist($seminaire);
            $e->flush();
            $id = $seminaire->getId();
            return $this->redirectToRoute('/creationSeminaireOk', ["id" => $id]);
        }

        return $this->render('requete/seminaire.html.twig', [
            'form' => $form->createView()

        ]);

    }

    /**
     * @Route("creationSeminaireOk/{id}", name="creationSeminaireOk")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function creationSeminaireOk(EntityManagerInterface $em, int $id) {

        $repo = $em->getRepository(Seminaire::class);
        $seminaire = $repo->find($id);
        return $this->render('requete/creationSeminaireOk.html.twig', [
            'seminaire' => $seminaire
        ]);
    }

    /**
     * @Route("/VoirTousLesTheme", name="VoirTousLesTheme")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function VoirTousLesTheme(Request $request,EntityManagerInterface $em) {
        $repo = $em->getRepository(Theme::class);
        $themes = $repo->findAll();
        return $this->render('requete/voirLesThemes.html.twig', [
            'themes' => $themes
        ]);
    }

    /**
     * @Route("/supprimerTheme/{id}", name="supprimerTheme")
     * @param EntityManagerInterface $em
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function supprimerTheme(EntityManagerInterface $em ,int $id) {
        $repo = $em->getRepository(Theme::class)->find($id);
        $em->remove($repo);
        $em->flush();
        return $this->redirectToRoute("VoirTousLesTheme");
    }

    /**
     * @Route("/voirTheme/{id}", name="voirTheme")
     * @param EntityManagerInterface $em
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voirTheme(EntityManagerInterface $em, int $id) {
        $theme = $em->getRepository(Theme::class)->find($id);

        return $this->render("requete/voirLeTheme.html.twig", ['theme' => $theme]);
    }



}
