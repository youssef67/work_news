<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    public function add(Comment $comment)
    {
        $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()');

        $q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());

        $q->execute();

        $comment->setId($this->dao->lastInsetId());
    }

    public function getListOf($news)
    {
        if(!ctype_digit($news))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news doit être un nombre entier');
        }

        $q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = :news');
        $q->bindValue(':news', $news, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $q->fetchAll(); 

        foreach ($comments as $comment)
        {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }

    public function modify(Comment $comment)
    {
        $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');
        $q->bindValue(':auteur', $comment->auteur());
        $q->bindValue(':contenu', $comment->contenu());
        $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $q->execute();
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT id, auteur, contenu, news FROM comments WHERE id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);

        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $q->fetch();
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM comments WHERE id = ' . (int) $id);
    }

    public function deleteFromNews($newsId)
    {
        $this->dao->exec('DELETE FROM comments WHERE news = ' . (int) $newsId); 
    }
}