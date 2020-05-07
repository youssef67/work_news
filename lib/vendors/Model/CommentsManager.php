<?php
namespace Model;

use Entity\Comment;
use OCFram\Manager;

abstract class CommentsManager extends Manager
{
    abstract protected function add(Comment $add);

    public function save(Comment $comment)
    {
        if ($comment->isValid())
        {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
        }
    }

    abstract public function getListOf($news);

    abstract public function modify(Comment $comment);

    abstract public function get($id);
}
       