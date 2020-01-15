<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller\Home;

use App\Controller;
use App\Model\Element\CommentsManager;
use App\Model\Element\NavbarManager;
use App\Controller\Map\MapController;

use App\Model\Element\BlogManager; // NOTE code de Guillaume
use App\Model\Element\ClipManager;
use App\Model\Element\ConcertsManager;
use App\Model\Element\PhotosManager; // fin de Guillaume
use App\Model\Element\GalleryNameManager;
use App\Model\Element\GalleryPhotoManager;
use DateTime;

class HomeController extends Controller\AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(int $page = 1)
    {
        $authority = $_SESSION["authority"];
        if (!isset($_SESSION["comment"])) {
            $_SESSION["comment"]="";
        }
        //navbar
        $navbarManager = new NavbarManager();
        $navbar = $navbarManager->selectByAuthority($authority);
        //article
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectAllArticle2(2, $page);
        $nbArticle = $blogManager->nbArticle();
        $nbPage = $blogManager->nbPage();

        $commentsManager = new CommentsManager();
        $comments = $commentsManager->selectAll();
        $commentsPhotos=$commentsManager->selectCommentByPhoto();

        // NOTE code de Guillaume
        $concertsManager = new ConcertsManager();
        $concert  = $concertsManager->selectOneById(2);
        $concerts = $concertsManager->selectAll();

        $photosManager = new PhotosManager();
        $photos = $photosManager->selectOneById(41);

        $clipManager=new ClipManager();
        $clip=$clipManager->selectLast();

        $galleryNameManager=new GalleryNameManager();
        $gallerName=$galleryNameManager->selectAllFromAll();

        $gallerPhotoManager=new GalleryPhotoManager();
        $galleryPhoto=$gallerPhotoManager->selectAll();

        $mapController = new MapController;

        $jsonConcerts = $mapController->map($concerts);

        return $this->twig->render('Home/index.html.twig', [
            'menus' => $navbar,
            'blogs' => $blogs,
            'nbArticle' => $nbArticle,
            'nbPage' => $nbPage,
            'comments' => $comments,
            'concert'  => $concert,
            'jsonConcerts' => $jsonConcerts,
            'photos' => $photos,
            'clip'=>$clip,
            'galleryName'=>$gallerName,
            'commentsPhotos'=>$commentsPhotos,
            'authority'=>$authority,
            'commentaire'=>$_SESSION["comment"],
            'galleryPhoto'=>$galleryPhoto]);
    }   // fin de Guillaume

    public function article(int $id)
    {
        $authority = $_SESSION["authority"];
        if (!isset($_SESSION["comment"])) {
            $_SESSION["comment"]="";
        }
        //navbar
        $navbarManager = new NavbarManager();
        $navbar = $navbarManager->selectByAuthority($authority);
        //article
        $blogManager = new BlogManager();
        $blogs = $blogManager->selectArticleById($id);

        $photosManager = new PhotosManager();
        $photos = $photosManager->selectOneById(41);

        $galleryNameManager=new GalleryNameManager();
        $gallerName=$galleryNameManager->selectAllFromAll();

        $gallerPhotoManager=new GalleryPhotoManager();
        $galleryPhoto=$gallerPhotoManager->selectAll();

        return $this->twig->render('Home/article.html.twig', [
            'menus' => $navbar,
            'blogs' => $blogs,
            'photos' => $photos,
            'galleryName'=>$gallerName,
            'authority'=>$authority,
            'commentaire'=>$_SESSION["comment"],
            'galleryPhoto'=>$galleryPhoto]);
    }
}
