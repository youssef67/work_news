<?php
namespace Model;

use Entity\News;
use \OCFram\Manager;

abstract class NewsManager extends Manager
{
    abstract public function getList($debut = -1, $limite = -1);

    abstract public function getUnique($id);

    abstract public function count();

    abstract public function add();

    public function save(News $news)
    {
        if ($news->isValid())
        {
            $news->isNew() ? $this->add($news) : $this->modify($news);
        }
        else
        {
            throw new \RuntimeException('La news doit être validée pour être enregistrée');
        }
    }
}