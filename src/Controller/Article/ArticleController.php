<?php

namespace App\Controller\Article;

use App\Controller\AbstractController;
use App\Model\Element\ClipManager;
use App\Model\Element\ConcertsManager;
use App\Model\Element\GalleryNameManager;
use App\Model\Element\GalleryPhotoManager;
use App\Model\Element\PhotosManager;
use App\Model\Admin\ArticleManager;
use App\Model\Element\BlogManager;
use App\Model\Element\NavbarManager;

class ArticleController extends AbstractController
{

    public function index()
    {
        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $tables=$this->getArticleJoinedTables();
            return $this->twig->render('Article/article.html.twig', $tables);
        }
    }
    public function doRoute()
    {
        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $articleManager = new ArticleManager;

            if (!empty($_POST['titre']) && (!empty($_POST['comment']))) {
                $articleManager->insertArticle(
                    htmlspecialchars($_POST['titre']),
                    htmlspecialchars($_POST['comment'])
                );
                if (!empty($_POST['id_concert'])) {
                    $articleManager->updateArticleConcert(
                        (int) htmlspecialchars($_SESSION["lastInsertId"]),
                        (int) htmlspecialchars($_POST['id_concert'])
                    );
                }
                if (!empty($_POST['id_clip'])) {
                    $articleManager->updateArticleClip(
                        (int) htmlspecialchars($_SESSION["lastInsertId"]),
                        (int) htmlspecialchars($_POST['id_clip'])
                    );
                }
                if (!empty($_POST['id_photos'])) {
                    $articleManager->updateArticlePhotos(
                        (int) htmlspecialchars($_SESSION["lastInsertId"]),
                        (int) htmlspecialchars($_POST['id_photos'])
                    );
                }
                if (!empty($_POST['id_gallery'])) {
                    $articleManager->updateArticleGallery(
                        (int) htmlspecialchars($_SESSION["lastInsertId"]),
                        (int) htmlspecialchars($_POST['id_gallery'])
                    );
                }
            }
            header('location:/Article/list');
        }
    }

    public function list()
    {

        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $navbarManager = new NavbarManager();
            $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);
            $articleManager = new ArticleManager();
            $articles = $articleManager->listArticle();
            return $this->twig->render(
                'Article/list.html.twig',
                ['articles' => $articles,"menus"=>$menus]
            );
        }
    }


    public function deleteArticle($parameters)
    {
        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $articleManager = new ArticleManager();
            $articleManager->deleteArticle((int) $parameters);
            header('location:/Article/list');
        }
    }
    public function doSessions()
    {
        $blogManager = new BlogManager;
        //si une id_blog a déjà été envoyée du formulaire du haut
        if (!empty($_POST['id_blog'])) {
            //on stocke la valeur envoyée id_blog dans une variable de session
            $_SESSION['id_blog'] = $_POST['id_blog'];
            //on charge tous les managers
            $clipManager = new ClipManager;
            $concertsManager = new ConcertsManager;
            $galleryNameManager = new GalleryNameManager;
            $galleryPhotoManager = new GalleryPhotoManager;
            $photosManager = new PhotosManager;
            $photos = $photosManager->selectAll();
            $blogs = $blogManager->selectOneById(
                (int) htmlspecialchars($_POST['id_blog'])
            );
            $_SESSION['titre'] = $blogs['title'];
            $_SESSION['text'] = $blogs['text'];
            $varIntermediaire = $concertsManager->selectOneById((int) $blogs['id_concert']);
            $_SESSION['concert'] = $varIntermediaire["title"];
            $varIntermediaire = $clipManager->selectOneById((int) $blogs['id_clip']);
            $_SESSION['clip'] = $varIntermediaire["name"];
            $varIntermediaire = $photosManager->selectOneById((int) $blogs['id_photos']);
            $_SESSION['photo'] = $varIntermediaire["name"];
            $varIntermediaire = $galleryNameManager->selectOneById((int) $blogs['id_pool_photos']);
            $_SESSION['gallery'] = $varIntermediaire["name"];
            $_SESSION['id_concert'] = $blogs['id_concert'];
            $_SESSION['id_clip'] = $blogs['id_clip'];
            $_SESSION['id_photo'] = $blogs['id_photos'];
            $_SESSION['id_gallery'] = $blogs['id_pool_photos'];
            $blogs = $blogManager->selectAll();
            $clips = $clipManager->selectAll();
            $concerts = $concertsManager->selectAll();
            $galleries = $galleryNameManager->selectAll();
            $galleriesPhotos = $galleryPhotoManager->selectAll();
            $navbarManager = new NavbarManager();
            $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);
            return $this->twig->render('Article/update.html.twig', [
                "blogs" => $blogs,
                "session" => $_SESSION,
                'clips' => $clips,
                'concerts' => $concerts,
                'galleries' => $galleries,
                'galleriesPhotos' => $galleriesPhotos,
                'photos' => $photos,
                'menus'=>$menus
            ]);
        }
    }
    public function update()
    {
        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $navbarManager = new NavbarManager();
            $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);
            
            $blogManager = new BlogManager();
            $blogs = $blogManager->selectAll();
            $_SESSION['titre'] = '';
            $_SESSION['text'] = '';
            $_SESSION['concert'] = '';
            $_SESSION['clip'] = '';
            $_SESSION['photo'] = '';
            $_SESSION['gallery'] = '';
            $_SESSION['id_concert'] = '';
            $_SESSION['id_clip'] = '';
            $_SESSION['id_photo'] = '';
            $_SESSION['id_gallery'] = '';
            return $this->twig->render(
                'Article/update.html.twig',
                ["blogs" => $blogs, "session" => $_SESSION,"menus"=>$menus]
            );
        }
    }
    public function doUpdate()
    {
        /*si dans le tableau de variable $_POST il y a bien une valeur pour
        $_POST['id_concert'], $_POST['id_clip'], $_POST['id_photos'], $_POST['id_gallery'], $_POST['id_blog']
        alors on attribue leur valeur sous forme de variable int aux variables
        $idConcert, $idClip, $idPhotos, $idGallery, $id
        sinon on leur donne la valeur null
        */
        $idConcert = $_POST['id_concert'] ? (int) $_POST['id_concert'] : 99;
        $idClip    = $_POST['id_clip']    ? (int) $_POST['id_clip']    : 99;
        $idPhotos  = $_POST['id_photos']  ? (int) $_POST['id_photos']  : 99;
        $idGallery = $_POST['id_gallery'] ? (int) $_POST['id_gallery'] : 99;
        $id        = $_POST['id_blog']    ? (int) $_POST['id_blog']    : null;

        $articleManager = new ArticleManager();
        $articleManager->updateArticle(
            (string) htmlspecialchars($_POST['titre']),
            (string) htmlspecialchars($_POST['text']),
            $idConcert,
            $idClip,
            $idPhotos,
            $idGallery,
            $id
        );
        header('location:/Article/list');
    }

    private function getArticleJoinedTables(): array
    {
        $clipManager = new ClipManager();
        $clips = $clipManager->selectAll();

        $concertsManager = new ConcertsManager();
        $concerts = $concertsManager->selectAll();

        $galleryNameManager = new GalleryNameManager();
        $galleries = $galleryNameManager->selectAll();

        $galleryPhotoManager = new GalleryPhotoManager();
        $galleriesPhotos = $galleryPhotoManager->selectAll();

        $photosManager = new PhotosManager();
        $photos = $photosManager->selectAll();

        $navbarManager = new NavbarManager();
        $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);

        $tables = [
            'clips'           => $clips,
            'concerts'        => $concerts,
            'galleries'       => $galleries,
            'galleriesPhotos' => $galleriesPhotos,
            'photos'          => $photos,
            'menus'           => $menus
        ];
        return $tables;
    }
}
