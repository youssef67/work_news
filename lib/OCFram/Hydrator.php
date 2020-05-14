<?php
namespace OCFram;

trait Hydrator
{
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $methode = 'set' . ucfirst($key);

            if (is_callable([$this, $methode]))
            {
                $this->$methode($value);
            }
        }
    }
}