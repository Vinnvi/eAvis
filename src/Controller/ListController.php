<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Avis;
use App\Entity\AvisSearch;
use App\Form\AvisType;
use App\Form\AvisSearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends AbstractController
{


  public function index(): Response
  {

    $repository = $this->getDoctrine()->getRepository(Article::class);

    $articles = $repository->findAll();

    return ($this->render('list.html.twig', [
      'articles' => $articles
    ]));
  }

  public function afficherArticle($id, Request $request, PaginatorInterface $paginator, Request $request2): Response
  {
    $avisRepository = $this->getDoctrine()->getRepository(Avis::class);
    $articleRepository = $this->getDoctrine()->getRepository(Article::class);

    $article = $articleRepository->findOneById($id);

    $search = new AvisSearch();
    $formSearch = $this->createForm(AvisSearchType::class, $search);
    $formSearch->handleRequest($request);

    $listeAvis = $paginator->paginate(
      $avisRepository->findByArticleIdQuery($id, $search),
      $request2->query->getInt('page', 1),
      2
    );

    if($article === Null) {
      return $this->redirectToRoute('list');
    }


    $avis = new Avis();
    $avis->setProduit($article);
    $form = $this->createForm(AvisType::class, $avis);


    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {

      $date = new \DateTime();
      $avis->setDate($date);

      $em = $this->getDoctrine()->getManager();

      $file = $form['photo']->getData();
      if($file !== Null) {
        $fileName = $date->getTimestamp();

        $extension = $file->guessExtension();
        if (!$extension) {
            // extension cannot be guessed
            $extension = 'jpg';
        }

        $directory = 'img/';
        $finalName = $fileName.'.'.$extension;
        $file->move($directory, $finalName);
        $avis->setPhoto($finalName);
      }

      $em->persist($avis);
      $em->flush();
      return $this->redirectToRoute('list');

    }

    return ($this->render('article.html.twig',[
      'article' => $article,
      'lAvis' => $listeAvis,
      'form' => $form->createView(),
      'avis' => $avis,
      'formSearch' => $formSearch->createView()
    ]));
  }


}

?>
