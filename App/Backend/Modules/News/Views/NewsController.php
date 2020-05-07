<?php
namespace App\Backend\Modules\News;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\News;

class NewsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des news');

        $manager = $this->managers->getManagerOf('News');

        $this->page->addVar('listeNews', $manager->getList());
        $this->page->addVar('nombreNews', $manager->count());
    }

    public function executeInsert(HTTPRequest $request)
    {
        if ($request->postExists('auteur'))
        {
            $this->processForm($request);
        }

        $this->page->addVar('title', 'Ajout d\'une news');
    }

    public function executeUpdate(HTTPRequest $request)
    {
        if ($request->postExists('auteur'))
        {
            $this->processForm($request);
        }
        else
        {
            $this->page->addVar('news', $this->managers->getManagerOf('News')->getUnique($request->getData('id')));

            $this->page->addVar('title', 'modification d\'une news');
        }
    }

    public function processForm(HTTPRequest $request)
    {
        $news = new News([
            'auteur' => $request->postData('auteur'),
            'titre' => $request->postData('titre'),
            'contenu' => $request->postData('contenu')
        ]);

        if ($request->postExists('id'))
        {
            $news->setId($request->postData('id'));
        }

        if ($news->isValid())
        {
            $this->managers->getManagerOf('News')->save($news);

            $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
        }
        else
        {
            $this->page->addVar('erreurs', $news->errreurs());
        }

        $this->page->addVar('news', $news);
    }

    public function executeDelete(HTTPRequest $request)
    {
        $this->managers->getManagerOf('News')->delete($request->getData(('id')));

        $this->app->user()->setFlash('La news a bien été supprimé');

        $this->app->httpResponse()->redirect('.');
    }

    public function executeUdpateComments(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Modification d\'un commentaire');

        if ($request->postExists('pseudo'))
        {
            $comment = new \Entity\Comment([
                'id' => $request->getData('id'),
                'auteur' => $request->postData('pseudo'),
                'contenu' => $request->postData('contenu')
            ]);

            if ($comment->isValid())
            {
                $this->managers->getManagerOf('Comments')->save($comment);

                $this->app->user()->setFlash('Le commentaire a bien été modifié');

                $this->app->httpResponse()->redirect('/news-' . $request->postData('news') . '.html');
            }
            else
            {
                $this->page->addVar('erreurs', $comment->errreurs());
            }

            $this->page->addVar('Comment', $comment);
        }
        else
        {
            $this->page->addVar('comment', $this->managers->getManagerOf('Comments')->get($request->getData('id')));
        }
    }
}